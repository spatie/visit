<?php

namespace App\Commands;

use App\Colorizers\Colorizer;
use App\Colorizers\DummyColorizer;
use App\Concerns\DisplaysMessages;
use App\Exceptions\InvalidMethod;
use App\Exceptions\InvalidPayload;
use App\Exceptions\InvalidUrlSpecified;
use App\Exceptions\NoUrlSpecified;
use App\Exceptions\RenderableException;
use App\Filters\DummyFilter;
use App\Filters\Filter;
use App\Stats\StatResult;
use App\Stats\StatsCollection;
use App\Support\Redirects;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Http\Client\Response;
use LaravelZero\Framework\Commands\Command;
use Soundasleep\Html2Text;
use Spatie\GuzzleRedirectHistoryMiddleware\RedirectHistory;
use Spatie\GuzzleRedirectHistoryMiddleware\RedirectHistoryMiddleware;
use Symfony\Component\Process\Process;
use function Termwind\{render};

class VisitCommand extends Command
{
    use DisplaysMessages;

    public $signature = '
        visit {url?}
            {--route=}
            {--method=}
            {--payload=}
            {--user=}
            {--show-exception}
            {--headers}
            {--follow-redirects}
            {--no-color}
            {--text}
            {--only-response}
            {--only-stats}
            {--filter=}
        ';

    public function handle()
    {
        if ($this->argument('url') === null) {
            $this->displayMessage('Welcome to Visit by Spatie. Pass a URL to get started.');

            return self::SUCCESS;
        }

        try {
            if ($this->shouldBeHandledWithLaravelVisit()) {
                $result = $this->handleWithLaravelVisit();

                return $result
                    ? self::SUCCESS
                    : self::FAILURE;
            }

            ['response' => $response, 'statResults' => $statResults, 'redirects' => $redirects] = $this->makeRequest();

            $this->renderResponse($response, $statResults, $redirects);

            return $response->successful() || $response->redirect()
                ? self::SUCCESS
                : self::FAILURE;
        } catch (RenderableException $exception) {
            $exception->render();
        }

        return self::FAILURE;
    }

    protected function laravelVisitIsAvailable(): bool
    {
        $composerJsonPath = getcwd() . '/composer.json';

        if (! file_exists($composerJsonPath)) {
            return false;
        }

        $composerJsonContent = json_decode(file_get_contents($composerJsonPath), true);

        foreach (['require', 'require-dev'] as $require) {
            foreach ($composerJsonContent[$require] ?? [] as $package => $version) {
                if ($package === 'spatie/laravel-visit') {
                    return true;
                }
            }
        }

        return false;
    }

    protected function handleWithLaravelVisit(): bool
    {
        $argumentsAndOptions = (string)$this->input;

        $process = Process::fromShellCommandline("php artisan visit {$argumentsAndOptions}");

        $process->setTty(true);
        $process->run();

        return $process->isSuccessful();
    }

    /** @return array{response: Response, statResults:array<int, \App\Stats\StatResult>, redirects: Redirects} */
    protected function makeRequest(): array
    {
        $method = $this->getMethod();

        $url = $this->getUrl();

        $stats = StatsCollection::fromConfig();

        $stats->callBeforeRequest();

        $request = app(PendingRequest::class);

        $redirectHistory = new RedirectHistory();
        $request->withMiddleware(RedirectHistoryMiddleware::make($redirectHistory));

        if (! $this->option('follow-redirects')) {
            $request->withoutRedirecting();
        }

        $response = $method === 'get'
            ? $request->$method($url)
            : $request->$method($url, $this->getPayload());

        $stats->callAfterRequest();

        $statResults = $stats->getResults();

        $redirects = new Redirects($redirectHistory);

        return compact('response', 'statResults', 'redirects');
    }

    /**
     * @param Response $response
     * @param array<int, StatResult $statResults
     * @param Redirects $redirects
     *
     * @return \App\Commands\VisitCommand
     */
    protected function renderResponse(Response $response, array $statResults, Redirects $redirects): self
    {
        if (! $this->option('only-stats')) {
            $this->renderContent($response);
        }

        if (! $this->option('only-response')) {
            $this->renderStats($response, $statResults, $redirects);
        }

        return $this;
    }

    protected function renderContent(Response $response): self
    {
        $content = $response->body();

        if ($filter = $this->option('filter')) {
            $filterClass = $this->getFilter($response, $content);

            $content = $filterClass->filter($response, $content, $filter);
        }

        if ($this->option('text')) {
            $content = Html2Text::convert($content, ['ignore_errors' => true]);

            $this->output->writeln($content);

            return $this;
        }

        if (! $this->option('no-color')) {
            $colorizer = $this->getColorizer($response);

            $content = $colorizer->colorize($content);
        }

        $this->output->writeln($content);

        return $this;
    }

    /**
     * @param Response $response
     * @param array<int, StatResult> $statResults
     * @param Redirects $redirects
     *
     * @return $this
     * @throws \App\Exceptions\NoUrlSpecified
     */
    protected function renderStats(Response $response, array $statResults, Redirects $redirects): self
    {
        $redirectingTo = '';

        if ($response->redirect() && $response->header('location')) {
            $redirectingTo = $response->header('location');
        }

        $requestPropertiesView = view('stats', [
            'method' => $this->getMethod(),
            'url' => $redirects->lastTo(),
            'statusCode' => $response->getStatusCode(),
            'content' => $response->body(),
            'headers' => $response->headers(),
            'redirects' => $redirects->all(),
            'redirectingTo' => $redirectingTo,
            'showHeaders' => $this->option('headers'),
            'headerStyle' => $this->getHeaderStyle($response),
            'statResults' => $statResults,
        ]);

        render($requestPropertiesView);

        return $this;
    }

    protected function getHeaderStyle(Response $response): string
    {
        if ($response->successful() || $response->redirect()) {
            return 'bg-green text-black';
        }

        return 'bg-red text-white';
    }

    protected function getColorizer(Response $response): Colorizer
    {
        $contentType = $response->header('content-type');

        $colorizer = collect(config('visit.colorizers'))
            ->map(fn (string $colorizerClassName) => app($colorizerClassName))
            ->first(fn (Colorizer $colorizer) => $colorizer->canColorize($contentType));

        return $colorizer ?? new DummyColorizer();
    }

    protected function getFilter(Response $response, string $content): Filter
    {
        $filter = collect(config('visit.filters'))
            ->map(fn (string $filterClassName) => app($filterClassName))
            ->first(fn (Filter $filter) => $filter->canFilter($response, $content));

        return $filter ?? new DummyFilter();
    }

    protected function getMethod(): string
    {
        $defaultMethodName = $this->option('payload') ? 'post' : 'get';

        $method = $this->option('method') ?? $defaultMethodName;

        $method = strtolower($method);

        $validMethodNames = collect(['get', 'post', 'put', 'patch', 'delete']);

        if (! $validMethodNames->contains($method)) {
            throw InvalidMethod::make($method, $validMethodNames);
        }

        return $method;
    }

    protected function getUrl(): string
    {
        $url = $this->argument('url');

        if (! $url) {
            throw NoUrlSpecified::make();
        }

        if (! str_starts_with($url, 'http')) {
            $url = "https://{$url}";
        }

        if(parse_url($url) === false) {
           throw InvalidUrlSpecified::make();
        }

        return $url;
    }

    protected function getPayload(): array
    {
        $payloadString = $this->option('payload');

        if (is_null($payloadString)) {
            return [];
        }

        $payload = json_decode($payloadString, true);

        if (is_null($payload)) {
            throw InvalidPayload::make();
        }

        return $payload;
    }

    protected function shouldBeHandledWithLaravelVisit(): bool
    {
        if (! $this->laravelVisitIsAvailable()) {
            return false;
        }

        if ($this->option('route')) {
            return true;
        }

        if ($this->option('user')) {
            return true;
        }

        $url = $this->argument('url');

        if (str_starts_with($url, '/')) {
            return true;
        }

        $firstSegment = explode('/', $url)[0];

        if (! str_contains($firstSegment, '.')) {
            return true;
        }

        return false;
    }
}

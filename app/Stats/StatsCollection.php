<?php

namespace App\Stats;

use Illuminate\Contracts\Foundation\Application;

class StatsCollection
{
    public static function fromConfig(): self
    {
        $items = collect(config('visit.stats'))
            ->map(fn (string $statsClassName) => app($statsClassName))
            ->toArray();

        return new self($items);
    }

    /**
     * @param array<int, Stat> $stats
     */
    protected function __construct(
        protected array $stats,
    ) {
    }

    public function callBeforeRequest(Application $app)
    {
        foreach ($this->stats as $stat) {
            $stat->beforeRequest($app);
        }
    }

    public function callAfterRequest(Application $app)
    {
        foreach ($this->stats as $stat) {
            $stat->afterRequest($app);
        }
    }

    /**
     * @return array<int, \App\Stats\StatResult>
     */
    public function getResults(): array
    {
        return collect($this->stats)
            ->map(fn (Stat $stat) => $stat->getStatResult())
            ->toArray();
    }
}

<?php

namespace App\Stats;

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

    public function callBeforeRequest()
    {
        foreach ($this->stats as $stat) {
            $stat->beforeRequest();
        }
    }

    public function callAfterRequest()
    {
        foreach ($this->stats as $stat) {
            $stat->afterRequest();
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

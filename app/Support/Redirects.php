<?php

namespace App\Support;

use Spatie\GuzzleRedirectHistoryMiddleware\RedirectHistory;

class Redirects
{
    protected array $redirects = [];

    public function __construct(RedirectHistory $redirectHistory)
    {
        $redirectHistory = $redirectHistory->toArray();

        if (! count($redirectHistory)) {
            return;
        }

        $this->redirects[] = ['from' => $redirectHistory[0]['url']];

        foreach ($redirectHistory as $redirectHistoryItem) {
            $this->add($redirectHistoryItem);
        }
    }

    /**
     * @return array<array{status: int, from: string, to: string}>
     */
    public function all(): array
    {
        if (! count($this->redirects)) {
            return [];
        }

        return array_slice($this->redirects, 0, -1);
    }

    public function lastTo(): string
    {
        $lastKey = array_key_last($this->redirects);

        return $this->redirects[$lastKey]['from'];
    }

    public function add(array $redirectHistoryItem)
    {
        $this
            ->addToLastItem('to', $redirectHistoryItem['url'])
            ->addToLastItem('status', $redirectHistoryItem['status']);

        $lastKey = array_key_last($this->redirects);

        $this->redirects[] = ['from' => $this->redirects[$lastKey]['to']];
    }

    protected function addToLastItem(string $key, string $value): self
    {
        $lastKey = array_key_last($this->redirects);

        $this->redirects[$lastKey][$key] = $value;

        return $this;
    }
}

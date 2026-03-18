<?php

declare(strict_types=1);

namespace Tests\Stubs;

use Darkheim\Infrastructure\Runtime\PostStore;

final class FixedPostStore implements PostStore
{
    public function __construct(private int $count)
    {
    }

    public function count(): int
    {
        return $this->count;
    }
}


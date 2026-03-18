<?php

declare(strict_types=1);

namespace Tests\Stubs;

use Darkheim\Infrastructure\Runtime\RequestStore;

final class ArrayRequestStore implements RequestStore
{
    /**
     * @param array<string, mixed> $data
     */
    public function __construct(private array $data = [])
    {
    }

    public function get(string $key, mixed $default = null): mixed
    {
        return $this->data[$key] ?? $default;
    }
}


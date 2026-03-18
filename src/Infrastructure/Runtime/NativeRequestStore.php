<?php

declare(strict_types=1);

namespace Darkheim\Infrastructure\Runtime;

final class NativeRequestStore implements RequestStore
{
    public function get(string $key, mixed $default = null): mixed
    {
        return $_REQUEST[$key] ?? $default;
    }
}


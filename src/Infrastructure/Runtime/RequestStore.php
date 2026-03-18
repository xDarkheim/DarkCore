<?php

declare(strict_types=1);

namespace Darkheim\Infrastructure\Runtime;

interface RequestStore
{
    public function get(string $key, mixed $default = null): mixed;
}


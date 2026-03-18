<?php

declare(strict_types=1);

namespace Darkheim\Infrastructure\Runtime;

final class NativePostStore implements PostStore
{
    public function count(): int
    {
        return count($_POST);
    }
}


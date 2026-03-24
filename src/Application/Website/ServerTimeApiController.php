<?php

declare(strict_types=1);

namespace Darkheim\Application\Website;

use Darkheim\Infrastructure\Http\JsonResponse;

final class ServerTimeApiController
{
    public function render(): void
    {
        JsonResponse::send([
            'code'       => 200,
            'ServerTime' => date('Y/m/d H:i:s'),
        ]);
    }
}

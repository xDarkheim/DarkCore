<?php

declare(strict_types=1);

use Darkheim\Application\Api\VersionApiController;
use Darkheim\Application\Api\ServerTimeApiController;
use Darkheim\Application\Api\PaypalApiController;
use Darkheim\Application\Api\GuildmarkApiController;
use Darkheim\Application\Api\EventsApiController;
use Darkheim\Application\Api\CastleSiegeApiController;

/**
 * API route registry.
 *
 * Key = endpoint name used by /api/{key}.php.
 */
return [
    'castlesiege' => [
        'controller' => CastleSiegeApiController::class,
    ],
    'events' => [
        'controller' => EventsApiController::class,
    ],
    'guildmark' => [
        'controller' => GuildmarkApiController::class,
    ],
    'paypal' => [
        'controller' => PaypalApiController::class,
    ],
    'servertime' => [
        'controller' => ServerTimeApiController::class,
    ],
    'version' => [
        'controller' => VersionApiController::class,
    ],
];


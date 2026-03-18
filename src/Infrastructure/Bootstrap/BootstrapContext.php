<?php

declare(strict_types=1);

namespace Darkheim\Infrastructure\Bootstrap;

use Darkheim\Infrastructure\Routing\Handler;

final class BootstrapContext
{
    private static ?ConfigProvider $configProvider = null;
    private static ?RuntimeState $runtimeState = null;
    private static ?Handler $handler = null;

    public static function initialize(ConfigProvider $configProvider, RuntimeState $runtimeState, Handler $handler): void
    {
        self::$configProvider = $configProvider;
        self::$runtimeState = $runtimeState;
        self::$handler = $handler;
    }

    public static function configProvider(): ?ConfigProvider
    {
        return self::$configProvider;
    }

    public static function runtimeState(): ?RuntimeState
    {
        return self::$runtimeState;
    }

    public static function handler(): ?Handler
    {
        return self::$handler;
    }
}


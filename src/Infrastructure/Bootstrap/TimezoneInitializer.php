<?php

declare(strict_types=1);

namespace Darkheim\Infrastructure\Bootstrap;

final class TimezoneInitializer
{
    public function __construct(private ConfigProvider $configProvider)
    {
    }

    public function apply(): string
    {
        $timezone = $this->configProvider->timezone();
        date_default_timezone_set($timezone);

        return $timezone;
    }
}


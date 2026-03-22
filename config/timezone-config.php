<?php

use Darkheim\Infrastructure\Bootstrap\ConfigProvider;
use Darkheim\Infrastructure\Bootstrap\TimezoneInitializer;

new TimezoneInitializer(
    new ConfigProvider(__DIR__),
)->apply();

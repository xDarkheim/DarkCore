<?php

use Darkheim\Application\CastleSiege\CastleSiege;
use Darkheim\Infrastructure\Cron\CronManager;

// File Name
$file_name = basename(__FILE__);

// Castle Siege
$castleSiege = new CastleSiege();
$castleSiege->updateSiegeCache();

// UPDATE CRON
(new CronManager())->updateLastRun($file_name);

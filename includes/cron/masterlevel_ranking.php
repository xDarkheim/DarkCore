<?php

use Darkheim\Application\Rankings\RankingsService as Rankings;
use Darkheim\Infrastructure\Cron\CronManager;

// File Name
$file_name = basename(__FILE__);

// Load Rankings Class
$Rankings = new Rankings();

// Load Ranking Configs
loadModuleConfigs('rankings');

if (mconfig('active') && mconfig('rankings_enable_master')) {
    $Rankings->UpdateRankingCache('master');
}

// UPDATE CRON
new CronManager()->updateLastRun($file_name);

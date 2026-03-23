<?php

use Darkheim\Application\Rankings\RankingsService as Rankings;
use Darkheim\Infrastructure\Bootstrap\BootstrapContext;
use Darkheim\Infrastructure\Cron\CronManager;

// File Name
$file_name = basename(__FILE__);

// Load Rankings Class
$Rankings = new Rankings();

// Load Ranking Configs
BootstrapContext::loadModuleConfig('rankings');

if (BootstrapContext::moduleValue('active') && BootstrapContext::moduleValue('rankings_enable_level')) {
    $Rankings->UpdateRankingCache('level');
}

// UPDATE CRON
new CronManager()->updateLastRun($file_name);

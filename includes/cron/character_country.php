<?php

use Darkheim\Infrastructure\Database\Connection;
use Darkheim\Infrastructure\Cache\CacheBuilder;
use Darkheim\Infrastructure\Cache\CacheRepository;
use Darkheim\Infrastructure\Cron\CronManager;

// File Name
$file_name = basename(__FILE__);

// load databases
$me = Connection::Database('MuOnline');
$charactersDB = config('SQL_DB_NAME', true);
$accountsDB = $charactersDB;

$query = "SELECT t2."._CLMN_CHR_NAME_.", t1.country FROM ".$accountsDB.".[dbo].".Account_Country." t1 INNER JOIN ".$charactersDB.".[dbo]."._TBL_CHR_." t2 ON t1.account = t2."._CLMN_CHR_ACCID_;

$charactersCountryList = $me->query_fetch($query);
$result = array();
if(is_array($charactersCountryList)) {
	foreach($charactersCountryList as $characterCountryData) {
		$result[$characterCountryData[_CLMN_CHR_NAME_]] = $characterCountryData['country'];
	}
}

$cacheData = CacheBuilder::encode($result);
(new CacheRepository(__PATH_CACHE__))->save('character_country.cache', $cacheData);

// UPDATE CRON
(new CronManager())->updateLastRun($file_name);

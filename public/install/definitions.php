<?php

/**
 * DarkCore
 *
 * @version 1.1.1
 * @author      Dmytro Hovenko <dmytro.hovenko@gmail.com>
 */

if (! defined('access') or ! access or access != 'install') {
    die();
}

/**
 * INSTALLER_VERSION
 */
define('INSTALLER_VERSION', '1.1.1');

/**
 * CMS_CONFIGURATION_FILE
 */
define('CMS_CONFIGURATION_FILE', 'config.json');

/**
 * CMS_WRITABLE_PATHS_FILE
 */
define('CMS_WRITABLE_PATHS_FILE', 'writable.json');

/**
 * CMS_DEFAULT_CONFIGURATION_FILE
 */
define('CMS_DEFAULT_CONFIGURATION_FILE', 'config.default.json');

$install['PDO_DSN'] = [
    1 => 'dblib',
];

/**
 * Tables defined in tables.php
 * Constants: Bans, Ban_Log, Blocked_IP, Credits_Config, Credits_Logs,
 * Cron, Downloads, FLA, News, Passchange_Request, PayPal_Transactions,
 * Plugins, Register_Account, Votes, Vote_Logs, Vote_Sites,
 * Account_Country, News_Translations
 */
$install['sql_list'] = [
    'BANS'                => Bans,
    'BAN_LOG'             => Ban_Log,
    'BLOCKED_IP'          => Blocked_IP,
    'CREDITS_CONFIG'      => Credits_Config,
    'CREDITS_LOGS'        => Credits_Logs,
    'CRON'                => Cron,
    'DOWNLOADS'           => Downloads,
    'FLA'                 => FLA,
    'NEWS'                => News,
    'PASSCHANGE_REQUEST'  => Passchange_Request,
    'PAYPAL_TRANSACTIONS' => PayPal_Transactions,
    'PLUGINS'             => Plugins,
    'REGISTER_ACCOUNT'    => Register_Account,
    'VOTES'               => Votes,
    'VOTE_LOGS'           => Vote_Logs,
    'VOTE_SITES'          => Vote_Sites,
    'ACCOUNT_COUNTRY'     => Account_Country,
    'NEWS_TRANSLATIONS'   => News_Translations,
];

$install['step_list'] = [
    ['install_intro.php',   'Intro'],
    ['install_step_1.php',  'Web Server Requirements'],
    ['install_step_2.php',  'Database Connection'],
    ['install_step_3.php',  'Create Tables'],
    ['install_step_4.php',  'Add Cron Jobs'],
    ['install_step_5.php',  'Website Configuration'],
];

$install['cron_jobs'] = [
    // cron_name, cron_description, cron_file_run, cron_run_time, cron_status, cron_protected, cron_file_md5
    ['Levels Ranking',      'Scheduled task to update characters level ranking',          'levels_ranking.php',      '300', '1', '0'],
    ['Resets Ranking',      'Scheduled task to update characters reset ranking',          'resets_ranking.php',      '300', '1', '0'],
    ['Killers Ranking',     'Scheduled task to update top killers ranking',               'killers_ranking.php',     '300', '1', '0'],
    ['Master Level Ranking','Scheduled task to update characters master level ranking',   'masterlevel_ranking.php', '300', '1', '0'],
    ['Guilds Ranking',      'Scheduled task to update top guilds ranking',                'guilds_ranking.php',      '300', '1', '0'],
    ['Grand Resets Ranking','Scheduled task to update characters grand reset ranking',    'grandresets_ranking.php', '300', '1', '0'],
    ['Online Ranking',      'Scheduled task to update top online ranking',                'online_ranking.php',      '300', '1', '0'],
    ['Gens Ranking',        'Scheduled task to update gens ranking',                      'gens_ranking.php',        '300', '1', '0'],
    ['Votes Ranking',       'Scheduled task to update vote rankings',                     'votes_ranking.php',       '300', '1', '0'],
    ['Castle Siege',        'Saves castle siege information in cache',                    'castle_siege.php',        '300', '1', '0'],
    ['Ban System',          'Scheduled task to lift temporal bans',                       'temporal_bans.php',       '300', '1', '0'],
    ['Server Info',         'Scheduled task to update sidebar statistics',                'server_info.php',         '300', '1', '0'],
    ['Account Country',     'Scheduled task to detect accounts country by IP',            'account_country.php',     '60',  '1', '0'],
    ['Character Country',   'Scheduled task to cache characters country',                 'character_country.php',   '300', '1', '0'],
    ['Online Characters',   'Scheduled task to cache online characters',                  'online_characters.php',   '300', '1', '0'],
];

$install['PDO_PWD_ENCRYPT'] = [
    'none',
    'wzmd5',
    'phpmd5',
    'sha256',
];

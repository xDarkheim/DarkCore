<?php

use Darkheim\Infrastructure\Cron\CronManager;
use Darkheim\Infrastructure\Database\Connection;

// File Name
$file_name = basename(__FILE__);

// load database
$database = Connection::Database('MuOnline');

$temporalBans = $database->query_fetch("SELECT * FROM " . Bans);
if (is_array($temporalBans)) {
    foreach ($temporalBans as $tempBan) {
        $banTimestamp = $tempBan['ban_days'] * 86400 + $tempBan['ban_date'];
        if (time() > $banTimestamp) {
            // lift ban
            $unban = $database->query("UPDATE " . _TBL_MI_ . " SET " . _CLMN_BLOCCODE_ . " = 0 WHERE " . _CLMN_USERNM_ . " = ?", [$tempBan['account_id']]);
            if ($unban) {
                $database->query("DELETE FROM " . Ban_Log . " WHERE account_id = ?", [$tempBan['account_id']]);
                $database->query("DELETE FROM " . Bans . " WHERE account_id = ?", [$tempBan['account_id']]);
            }
        }
    }
}

// UPDATE CRON
new CronManager()->updateLastRun($file_name);

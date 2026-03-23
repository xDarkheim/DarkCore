<?php

declare(strict_types=1);

namespace Darkheim\Infrastructure\Security;

use Darkheim\Domain\Validator;
use Darkheim\Infrastructure\Cache\CacheRepository;

/**
 * Checks whether the current visitor's IP is on the blocked-IP list.
 *
 * Replaces the inline logic in the global checkBlockedIp() helper.
 */
final class IpBlocker
{
    /**
     * Returns true when the current REMOTE_ADDR is blocked.
     *
     * – Returns false (not blocked) when the IP cannot be determined or is
     *   malformed so we fail open and don't accidentally lock everyone out.
     * – Returns false when the blocked-IP cache is missing or empty.
     */
    public static function isCurrentIpBlocked(): bool
    {
        if (! isset($_SERVER['REMOTE_ADDR'])) {
            return false;
        }

        $ip = $_SERVER['REMOTE_ADDR'];

        if (! Validator::Ip($ip)) {
            return false;
        }

        $cacheDir = defined('__PATH_CACHE__') ? __PATH_CACHE__ : '';
        $blocked  = new CacheRepository($cacheDir)->load('blocked_ip.cache');

        if (! is_array($blocked)) {
            return false;
        }

        return in_array($ip, $blocked, true);
    }
}

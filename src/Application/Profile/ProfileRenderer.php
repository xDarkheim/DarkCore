<?php

declare(strict_types=1);

namespace Darkheim\Application\Profile;

use Darkheim\Infrastructure\Bootstrap\BootstrapContext;

/**
 * Renders clickable player and guild profile links.
 *
 * Replaces the inline logic of the global playerProfile() / guildProfile()
 * helper functions. Call those helpers from legacy code; use this class in
 * new code.
 */
final class ProfileRenderer
{
    /**
     * Returns an <a> tag (or just the URL when $linkOnly is true) linking to
     * the player's profile page. Returns the raw $name when profiles are disabled.
     */
    public static function player(string $playerName, bool $linkOnly = false): string
    {
        if (!self::profilesEnabled('player_profiles')) {
            return $playerName;
        }

        $encoded = self::isEncoded();
        $slug    = $encoded
            ? self::base64urlEncode($playerName)
            : urlencode($playerName);

        $base = (defined('__BASE_URL__') ? (string) __BASE_URL__ : '') . 'profile/player/req/' . $slug;

        if ($linkOnly) {
            return $base;
        }

        return '<a href="' . $base . '/">' . htmlspecialchars($playerName, ENT_QUOTES) . '</a>';
    }

    /**
     * Returns an <a> tag (or just the URL when $linkOnly is true) linking to
     * the guild's profile page. Returns the raw $guildName when profiles are disabled.
     */
    public static function guild(string $guildName, bool $linkOnly = false): string
    {
        if (!self::profilesEnabled('guild_profiles')) {
            return $guildName;
        }

        $encoded = self::isEncoded();
        $slug    = $encoded
            ? self::base64urlEncode($guildName)
            : urlencode($guildName);

        $base = (defined('__BASE_URL__') ? (string) __BASE_URL__ : '') . 'profile/guild/req/' . $slug;

        if ($linkOnly) {
            return $base;
        }

        return '<a href="' . $base . '/">' . htmlspecialchars($guildName, ENT_QUOTES) . '</a>';
    }

    // -----------------------------------------------------------------------
    // Helpers
    // -----------------------------------------------------------------------

    private static function profilesEnabled(string $key): bool
    {
        try {
            $cms = BootstrapContext::configProvider()?->cms();
        } catch (\Throwable) {
            return false;
        }

        return is_array($cms) && !empty($cms[$key]);
    }

    private static function isEncoded(): bool
    {
        try {
            $cfg = BootstrapContext::configProvider()?->moduleConfig('profiles');
        } catch (\Throwable) {
            return false;
        }

        return is_array($cfg) && isset($cfg['encode']) && $cfg['encode'] == 1;
    }

    /** Replicates the base64url_encode() logic without depending on the global function. */
    private static function base64urlEncode(string $data): string
    {
        $b64 = base64_encode($data . '!we');
        $url = strtr($b64, '+/', '-_');

        return rtrim($url, '=');
    }
}


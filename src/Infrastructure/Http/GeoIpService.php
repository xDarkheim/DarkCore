<?php

declare(strict_types=1);

namespace Darkheim\Infrastructure\Http;

/**
 * Geo-IP lookup and country-flag URL helper.
 *
 * Replaces the global getCountryCodeFromIp() / getCountryFlag() helpers.
 */
final class GeoIpService
{
    private const string API_URL = 'https://ip-api.com/json/%s?fields=status,countryCode';

    /**
     * Resolves the ISO-3166-1 alpha-2 country code for the given IP address.
     * Returns null on failure or when the API reports a failed lookup.
     */
    public static function getCountryCode(string $ip): ?string
    {
        $url    = sprintf(self::API_URL, rawurlencode($ip));
        $handle = curl_init();
        curl_setopt($handle, CURLOPT_URL, $url);
        curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($handle, CURLOPT_TIMEOUT, 5);
        $json = curl_exec($handle);
        curl_close($handle);

        if (! $json || ! is_string($json)) {
            return null;
        }

        try {
            $result = json_decode($json, true, 512, JSON_THROW_ON_ERROR);
        } catch (\JsonException) {
            return null;
        }

        if (! is_array($result) || ($result['status'] ?? '') === 'fail') {
            return null;
        }

        $code = $result['countryCode'] ?? '';

        return (is_string($code) && $code !== '') ? $code : null;
    }

    /**
     * Returns the URL to the flag image for the given country code.
     * Falls back to 'default' when the code is empty.
     */
    public static function flagUrl(string $countryCode = 'default'): string
    {
        $code = ($countryCode === '' || $countryCode === 'default')
            ? 'default'
            : strtolower($countryCode);

        $base = defined('__PATH_COUNTRY_FLAGS__') ? (string) constant('__PATH_COUNTRY_FLAGS__') : '';

        return $base . $code . '.gif';
    }
}

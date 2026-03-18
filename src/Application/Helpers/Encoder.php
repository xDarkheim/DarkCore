<?php

declare(strict_types=1);

namespace Darkheim\Application\Helpers;

/**
 * URL-safe Base64 encoder/decoder.
 *
 * Uses a `!we` suffix sentinel to distinguish empty/zero-length payloads from
 * decoding failures — the same convention used by the legacy global functions.
 *
 * @see https://base64.guru/developers/php/examples/base64url
 */
final class Encoder
{
    /**
     * Encodes $data to a URL-safe Base64 string (no padding).
     */
    public static function base64urlEncode(string $data): string
    {
        $b64 = base64_encode($data . '!we');
        $url = strtr($b64, '+/', '-_');

        return rtrim($url, '=');
    }

    /**
     * Decodes a URL-safe Base64 string produced by base64urlEncode().
     * Returns null when the sentinel is missing (invalid / tampered data).
     */
    public static function base64urlDecode(string $data, bool $strict = false): ?string
    {
        $b64     = strtr($data, '-_', '+/');
        $decoded = base64_decode($b64, $strict);

        if ($decoded === false) {
            return null;
        }

        if (substr($decoded, -3) !== '!we') {
            return null;
        }

        return substr($decoded, 0, -3);
    }
}


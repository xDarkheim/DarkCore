<?php

declare(strict_types=1);

namespace Darkheim\Domain\Validation;

use Darkheim\Infrastructure\Bootstrap\BootstrapContext;

/**
 * Input validation — all methods are static.
 */
class Validator
{
    private static function textHit(string $string, array|string $exclude = ''): bool
    {
        if (empty($exclude)) {
            return false;
        }

        if (is_array($exclude)
            && array_any(
                $exclude,
                static fn($text): bool => is_string($text) && str_contains($string, $text),
            )
        ) {
            return true;
        }

        if (! is_string($exclude)) {
            return false;
        }

        return str_contains($string, $exclude);
    }

    private static function numberBetween($integer, $max = null, $min = 0): bool
    {
        if (is_numeric($min) && $integer < $min) {
            return false;
        }
        return ! (is_numeric($max) && $integer > $max)
        ;
    }

    public static function Email(string $string, array|string $exclude = ''): bool
    {
        if (self::textHit($string, $exclude)) {
            return false;
        }
        return (bool) preg_match("/^([a-z0-9])(([-a-z0-9._])*([a-z0-9]))*@([a-z0-9])(([a-z0-9-])*([a-z0-9]))+(\\.([a-z0-9])([-a-z0-9_-])?([a-z0-9])+)+$/i", $string);
    }

    public static function Url(string $string, array|string $exclude = ''): bool
    {
        if (self::textHit($string, $exclude)) {
            return false;
        }
        return (bool) preg_match("/^(http|https|ftp):\\/\\/([A-Z0-9][A-Z0-9_-]*(?:\\.[A-Z0-9][A-Z0-9_-]*)+):?(\\d+)?\\/?/i", $string);
    }

    public static function Ip(string $string): bool
    {
        return (bool) filter_var($string, FILTER_VALIDATE_IP);
    }

    public static function Number($integer, $max = null, $min = 0): bool
    {
        if (preg_match("/^-?[0-9e]+$/", (string) $integer)) {
            return self::numberBetween($integer, $max, $min)
            ;
        }
        return false;
    }

    public static function UnsignedNumber($integer): bool
    {
        return (bool) preg_match("/^\\+?[0-9]+$/", (string) $integer);
    }

    public static function Float($string): bool
    {
        return ($string == (string) (float) $string);
    }

    public static function Alpha(string $string): bool
    {
        return (bool) preg_match("/^[a-zA-Z]+$/", $string);
    }

    public static function AlphaNumeric(string $string): bool
    {
        return (bool) preg_match("/^[0-9a-zA-Z]+$/", $string);
    }

    public static function Chars(string $string, array $allowed = ['a-z']): bool
    {
        return (bool) preg_match("/^[" . implode("", $allowed) . "]+$/", $string);
    }

    public static function Length(string $string, $max = null, $min = 0): bool
    {
        $length = strlen($string);
        return self::numberBetween($length, $max, $min)
        ;
    }

    public static function Date(string $string): bool
    {
        $date = date('Y', (int) strtotime($string));
        return $date !== '1970';
    }

    /**
     * Returns true when a value is considered non-empty.
     * Mirrors the legacy \Darkheim\Domain\Validation\Validator::hasValue() global helper:
     *   – non-empty arrays/objects/strings are truthy
     *   – the literal string '0' is also truthy (explicit zero is valid)
     */
    public static function hasValue(mixed $value): bool
    {
        return (@count((array) $value) > 0 && ! @empty($value)) || $value === '0';
    }

    public static function UsernameLength(string $string): bool
    {
        return ! (strlen($string) < BootstrapContext::cmsValue('username_min_len', true) || strlen($string) > BootstrapContext::cmsValue('username_max_len', true));
    }

    public static function PasswordLength(string $string): bool
    {
        return ! (strlen($string) < BootstrapContext::cmsValue('password_min_len', true) || strlen($string) > BootstrapContext::cmsValue('password_max_len', true));
    }
}

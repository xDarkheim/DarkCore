<?php

declare(strict_types=1);

namespace Darkheim\Infrastructure\Helpers;

use Darkheim\Infrastructure\Config\JsonConfigReader;

/**
 * Filesystem utilities.
 *
 * Replaces the global loadJsonFile(), readableFileSize(),
 * and getDirectoryListFromPath() helpers.
 */
final class FileHelper
{
    /**
     * Reads and JSON-decodes a file. Returns null on any failure.
     *
     * @return array<mixed>|null
     */
    public static function readJson(string $filePath): ?array
    {
        return (new JsonConfigReader())->readFile($filePath);
    }

    /**
     * Returns the names of all immediate subdirectories inside $path,
     * or null when the path doesn't exist or contains no directories.
     *
     * @return string[]|null
     */
    public static function listDirectories(string $path): ?array
    {
        if (!is_dir($path)) {
            return null;
        }

        $result = [];
        $base   = rtrim(str_replace('\\', '/', $path), '/') . '/';

        foreach (scandir($path) ?: [] as $entry) {
            if (in_array($entry, ['.', '..'], true)) {
                continue;
            }
            if (is_dir($base . $entry)) {
                $result[] = $entry;
            }
        }

        return count($result) > 0 ? $result : null;
    }

    /**
     * Returns a human-readable string for a byte count.
     *
     * @see https://www.php.net/manual/en/function.filesize.php#106569
     */
    public static function readableSize(int $bytes, int $decimals = 2): string
    {
        $sz     = 'BKMGTP';
        $factor = (int) floor((strlen((string) $bytes) - 1) / 3);

        return sprintf("%.{$decimals}f", $bytes / (1024 ** $factor)) . ($sz[$factor] ?? '');
    }
}


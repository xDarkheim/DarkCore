<?php

declare(strict_types=1);

namespace Darkheim\Application\Shared\Language;

use Darkheim\Infrastructure\Helpers\FileHelper;

/**
 * Query installed language packs.
 *
 * Replaces the global getInstalledLanguagesList() helper.
 */
final class LanguageRepository
{
    /**
     * Returns the list of installed language codes.
     *
     * A language is considered installed when its directory contains a
     * `language.php` file under __PATH_LANGUAGES__.
     *
     * @return string[]|null
     */
    public static function getInstalled(): ?array
    {
        $langPath = defined('__PATH_LANGUAGES__') ? __PATH_LANGUAGES__ : '';
        $dirs     = FileHelper::listDirectories($langPath);

        if (! is_array($dirs)) {
            return null;
        }

        $result = [];
        $base   = rtrim($langPath, '/') . '/';

        foreach ($dirs as $lang) {
            if (is_file($base . $lang . '/language.php')) {
                $result[] = $lang;
            }
        }

        return count($result) > 0 ? $result : null;
    }
}

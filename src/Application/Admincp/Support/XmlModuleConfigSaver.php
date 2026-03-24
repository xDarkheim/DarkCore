<?php

declare(strict_types=1);

namespace Darkheim\Application\Admincp\Support;

final class XmlModuleConfigSaver
{
    /**
     * @param array{xml:string,fields:array<string,string>,base?:string} $moduleConfig
     * @param array<string,mixed> $postedValues
     */
    public function save(array $moduleConfig, array $postedValues): bool
    {
        $basePath = $moduleConfig['base']
            ?? $this->moduleConfigsBasePath();

        $xmlPath = $basePath . $moduleConfig['xml'];
        if (! is_file($xmlPath) || ! is_readable($xmlPath)) {
            return false;
        }

        $xmlRaw = file_get_contents($xmlPath);
        if ($xmlRaw === false) {
            return false;
        }

        $xml = simplexml_load_string($xmlRaw);
        if (! $xml instanceof \SimpleXMLElement) {
            return false;
        }

        foreach ($moduleConfig['fields'] as $postKey => $xmlField) {
            $xml->{$xmlField} = isset($postedValues[$postKey])
                ? (string) $postedValues[$postKey]
                : '';
        }

        return (bool) $xml->asXML($xmlPath);
    }

    private function moduleConfigsBasePath(): string
    {
        if (defined('__PATH_MODULE_CONFIGS__')) {
            return (string) constant('__PATH_MODULE_CONFIGS__');
        }

        return '';
    }
}

<?php

declare(strict_types=1);

namespace Darkheim\Infrastructure\Bootstrap;

use Darkheim\Infrastructure\Config\ConfigRepository;
use Darkheim\Infrastructure\Config\XmlConfigReader;

final class ConfigProvider
{
    private string $configDir;
    private string $moduleConfigDir;
    private ConfigRepository $configRepository;
    private XmlConfigReader $xmlReader;
    private bool $cmsLoaded = false;

    /** @var array<string, mixed> */
    private array $cmsConfig = [];

    public function __construct(
        string $configDir,
        ?ConfigRepository $configRepository = null,
        ?XmlConfigReader $xmlReader = null,
    ) {
        $this->configDir = rtrim(str_replace('\\', '/', $configDir), '/') . '/';
        $this->moduleConfigDir = $this->configDir . 'modules/';
        $this->configRepository = $configRepository ?? new ConfigRepository($this->configDir);
        $this->xmlReader = $xmlReader ?? new XmlConfigReader();
    }

    /**
     * @return array<string, mixed>
     *
     * @throws \Exception
     */
    public function cms(): array
    {
        if (!$this->cmsLoaded) {
            $this->cmsConfig = $this->configRepository->loadCmsOrFail();
            $this->cmsLoaded = true;
        }

        return $this->cmsConfig;
    }

    /**
     * @return array<string, mixed>|null
     */
    public function config(string $name = 'cms'): ?array
    {
        if ($name === '') {
            return null;
        }

        return $this->configRepository->load($name);
    }

    /**
     * @return array<string, mixed>|null
     */
    public function moduleConfig(string $module): ?array
    {
        if ($module === '') {
            return null;
        }

        return $this->xmlReader->readFile($this->moduleConfigDir . $module . '.xml');
    }

    /**
     * @return array<string, mixed>|null
     */
    public function globalXml(string $name): ?array
    {
        if ($name === '') {
            return null;
        }

        return $this->xmlReader->readFile($this->configDir . $name . '.xml');
    }

    public function timezone(): string
    {
        $config = $this->config('cms');
        $timezone = is_array($config) ? ($config['docker_timezone'] ?? 'UTC') : 'UTC';

        return is_string($timezone) && trim($timezone) !== '' ? $timezone : 'UTC';
    }
}


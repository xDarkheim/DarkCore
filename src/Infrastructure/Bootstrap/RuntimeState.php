<?php

declare(strict_types=1);

namespace Darkheim\Infrastructure\Bootstrap;

final class RuntimeState
{
    /** @var array<string, mixed> */
    private array $languagePhrases = [];

    /** @var array<string, mixed> */
    private array $moduleConfig = [];

    /** @var array<string, mixed> */
    private array $globalConfig = [];

    /** @var array<string, mixed> */
    private array $customConfig = [];

    /**
     * @param array<string, mixed> $phrases
     */
    public function setLanguagePhrases(array $phrases): void
    {
        $this->languagePhrases = $phrases;
    }

    /**
     * @return array<string, mixed>
     */
    public function languagePhrases(): array
    {
        return $this->languagePhrases;
    }

    /**
     * @param array<string, mixed> $config
     */
    public function setModuleConfig(array $config): void
    {
        $this->moduleConfig = $config;
    }

    /**
     * @return array<string, mixed>
     */
    public function moduleConfig(): array
    {
        return $this->moduleConfig;
    }

    /**
     * @param array<string, mixed> $config
     */
    public function setGlobalConfig(array $config): void
    {
        $this->globalConfig = $config;
    }

    /**
     * @return array<string, mixed>
     */
    public function globalConfig(): array
    {
        return $this->globalConfig;
    }

    /**
     * @param array<string, mixed> $config
     */
    public function setCustomConfig(array $config): void
    {
        $this->customConfig = $config;
    }

    /**
     * @return array<string, mixed>
     */
    public function customConfig(): array
    {
        return $this->customConfig;
    }
}


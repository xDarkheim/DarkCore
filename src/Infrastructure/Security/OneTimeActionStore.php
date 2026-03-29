<?php

declare(strict_types=1);

namespace Darkheim\Infrastructure\Security;

final class OneTimeActionStore
{
    private string $basePath;

    public function __construct(?string $basePath = null)
    {
        $root           = $basePath ?? (__PATH_CACHE__ . 'security/');
        $this->basePath = rtrim(str_replace('\\', '/', $root), '/') . '/';
    }

    /**
     * @param array<string,mixed> $payload
     */
    public function save(string $bucket, string $key, array $payload): bool
    {
        $path = $this->pathFor($bucket, $key);
        $dir  = dirname($path);

        if (! is_dir($dir) && ! mkdir($dir, 0o775, true) && ! is_dir($dir)) {
            return false;
        }

        $encoded = json_encode($payload, JSON_THROW_ON_ERROR | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
        return file_put_contents($path, $encoded, LOCK_EX) !== false;
    }

    /**
     * @return array<string,mixed>|null
     */
    public function load(string $bucket, string $key): ?array
    {
        $path = $this->pathFor($bucket, $key);
        if (! is_file($path)) {
            return null;
        }

        $raw = file_get_contents($path);
        if ($raw === false || trim($raw) === '') {
            return null;
        }

        $decoded = json_decode($raw, true, 512, JSON_THROW_ON_ERROR);
        return is_array($decoded) ? $decoded : null;
    }

    public function delete(string $bucket, string $key): bool
    {
        $path = $this->pathFor($bucket, $key);
        return ! file_exists($path) || unlink($path);
    }

    /**
     * @return array<int,array<string,mixed>>
     */
    public function all(string $bucket): array
    {
        $dir = $this->bucketPath($bucket);
        if (! is_dir($dir)) {
            return [];
        }

        $files = glob($dir . '*.json');
        if ($files === false) {
            return [];
        }

        $records = [];
        foreach ($files as $file) {
            $raw = file_get_contents($file);
            if ($raw === false || trim($raw) === '') {
                continue;
            }

            $decoded = json_decode($raw, true, 512, JSON_THROW_ON_ERROR);
            if (is_array($decoded)) {
                $records[] = $decoded;
            }
        }

        return $records;
    }

    private function pathFor(string $bucket, string $key): string
    {
        return $this->bucketPath($bucket) . hash('sha256', $key) . '.json';
    }

    private function bucketPath(string $bucket): string
    {
        $normalized = preg_replace('/[^a-z0-9_-]/i', '', strtolower($bucket)) ?: 'default';
        return $this->basePath . $normalized . '/';
    }
}

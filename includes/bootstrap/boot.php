<?php

/**
 * DarkCore
 *
 * Thin entry point. Boots AppKernel, which wires all services and loads the
 * global compat shim (compat.php). Modern bootstrap logic lives in
 * `src/Infrastructure/Bootstrap/`.
 */

$projectRoot = dirname(__DIR__, 2);

if (file_exists($projectRoot . '/vendor/autoload.php')) {
	require_once $projectRoot . '/vendor/autoload.php';
}

$kernel = new \Darkheim\Infrastructure\Bootstrap\AppKernel(dirname(__DIR__));
$kernel->boot();
$handler = $kernel->handler();


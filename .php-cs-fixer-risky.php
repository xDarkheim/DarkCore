<?php

declare(strict_types=1);

use PhpCsFixer\Config;

$config = require __DIR__ . '/.php-cs-fixer.php';

if (!$config instanceof Config) {
    throw new RuntimeException('Expected Config from .php-cs-fixer.php');
}

$rules = $config->getRules();
$rules['@PHP8x4Migration:risky'] = true;
$rules['random_api_migration'] = true;
$rules['no_alias_functions'] = true;
$rules['modernize_strpos'] = true;
$rules['declare_strict_types'] = true;
$rules['return_assignment'] = true;
$rules['strict_comparison'] = true;
$rules['void_return'] = true;

return $config
    ->setRiskyAllowed(true)
    ->setRules($rules);


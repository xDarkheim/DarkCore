<?php

declare(strict_types=1);

use PhpCsFixer\Config;
use PhpCsFixer\Finder;

$scanDirectories = [
    __DIR__ . '/src',
    __DIR__ . '/includes',
    __DIR__ . '/config',
    __DIR__ . '/tests',
    __DIR__ . '/bin',
];

$finder = Finder::create()
    ->in(array_values(array_filter($scanDirectories, static fn(string $path): bool => is_dir($path))))
    ->exclude(['vendor', 'cache', 'logs', 'var'])
    ->notPath('includes/languages')
    ->notPath('includes/plugins')
    ->name('*.php');

return new Config()
    ->setRiskyAllowed(false)
    ->setRules([
        '@PER-CS2.0'       => true,
        '@PHP8x4Migration' => true,

        // Array style
        'array_syntax'                    => ['syntax' => 'short'],
        'no_trailing_comma_in_singleline' => true,
        'trailing_comma_in_multiline'     => ['elements' => ['arrays', 'parameters', 'arguments']],

        // Imports
        'ordered_imports'         => ['sort_algorithm' => 'alpha'],
        'no_unused_imports'       => true,
        'global_namespace_import' => ['import_classes' => false],

        // Operators & spacing
        'binary_operator_spaces'             => ['default' => 'align_single_space_minimal'],
        'concat_space'                       => ['spacing' => 'one'],
        'not_operator_with_successor_space'  => true,
        'object_operator_without_whitespace' => true,
        'standardize_not_equals'             => true,

        // PHP modernisation
        'native_function_casing' => true,
        'cast_spaces'            => ['space' => 'single'],

        // Control flow
        'no_useless_else'      => true,
        'no_useless_return'    => true,
        'simplified_if_return' => true,

        // Comments
        'single_line_comment_style' => ['comment_types' => ['hash']],
        'no_empty_comment'          => true,

        // Misc
        'phpdoc_trim'            => true,
        'phpdoc_no_empty_return' => true,
    ])
    ->setFinder($finder);

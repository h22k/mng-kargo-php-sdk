<?php

use PhpCsFixer\Config;
use PhpCsFixer\Finder;

$finder = (new Finder())
    ->files()
    ->name('*.php')
    ->in(__DIR__ . '/src')
    ->in(__DIR__ . '/tests');

return (new Config())
    ->setRules([
        '@PhpCsFixer' => true,
        '@PHP81Migration' => true,
        'global_namespace_import' => true,
        'php_unit_internal_class' => false,
    ])
    ->setFinder($finder);

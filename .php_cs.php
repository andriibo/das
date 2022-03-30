<?php

$finder = PhpCsFixer\Finder::create()
    ->exclude('database/migrations')
    ->exclude('bootstrap/cache')
    ->exclude('storage')
    ->exclude('vendor')
    ->notPath('_ide_helper.php')
    ->notPath('_ide_helper_models.php')
    ->notPath('.phpstorm.meta.php')
    ->in(__DIR__)
    ->name('*.php')
    ->notName('*.blade.php')
    ->ignoreDotFiles(true)
    ->ignoreVCS(true)
;

$config = new PhpCsFixer\Config();
$config
    ->setRiskyAllowed(true)
    ->setRules([
        '@PHP81Migration' => true,
        '@PhpCsFixer' => true,
        'yoda_style' => false,
        'concat_space' => ['spacing' => 'one'],
        'single_line_comment_style' => [
            'comment_types' => ['hash']
        ],
    ])
    ->setFinder($finder)
;

return $config;

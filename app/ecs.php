<?php

declare(strict_types=1);

use Symplify\CodingStandard\Fixer\LineLength\LineLengthFixer;
use Symplify\EasyCodingStandard\Config\ECSConfig;
use Symplify\EasyCodingStandard\ValueObject\Set\SetList;

return static function (ECSConfig $ecsConfig): void {
    $ecsConfig->parallel();

    $ecsConfig->paths([
        __DIR__ . '/src',
        __DIR__ . '/tests',
        __DIR__ . '/config/bundles.php',
        __DIR__ . '/.ecs',
        __DIR__ . '/ecs.php',
        __DIR__ . '/bin/console',
        __DIR__ . '/public/index.php',
    ]);

    $ecsConfig->import(__DIR__ . '/.ecs/*.php');

    $ecsConfig->dynamicSets(['@Symfony']);

    $ecsConfig->sets([
        SetList::COMMON,
        SetList::PSR_12,
        SetList::CLEAN_CODE,
        SetList::SYMPLIFY,
    ]);

    $ecsConfig->ruleWithConfiguration(LineLengthFixer::class, [
        'inline_short_lines' => false,
    ]);
};

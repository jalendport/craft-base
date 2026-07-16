<?php

declare(strict_types=1);

use craft\ecs\SetList;
use PhpCsFixer\Fixer\Strict\DeclareStrictTypesFixer;
use Symplify\EasyCodingStandard\Config\ECSConfig;

return static function(ECSConfig $ecsConfig): void {
    $ecsConfig->paths([
        __DIR__ . '/src',
        __DIR__ . '/tests',
        __FILE__,
    ]);

    $ecsConfig->parallel();
    $ecsConfig->sets([SetList::CRAFT_CMS_4]);

    // House rule: declare(strict_types=1) in every file.
    $ecsConfig->rule(DeclareStrictTypesFixer::class);
};

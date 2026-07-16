<?php

declare(strict_types=1);

namespace jalendport\base;

use Craft;
use craft\base\Plugin as CraftPlugin;
use craft\events\RegisterTemplateRootsEvent;
use craft\web\View;
use yii\base\Event;

/**
 * Base class for all jalendport plugins.
 *
 * Extending this instead of craft\base\Plugin gets a plugin: a per-plugin
 * log file with static log helpers (see LogTrait), an `@<handle>` alias,
 * and the shared `jalendport-base` CP template root (settings macros).
 *
 * @author Jalen Davenport <hello@jalendport.com>
 * @copyright Jalen Davenport
 * @license MIT
 */
abstract class Plugin extends CraftPlugin
{
    use LogTrait;

    public function init(): void
    {
        parent::init();

        Craft::setAlias('@' . $this->id, $this->getBasePath());

        $this->registerLogTarget();
        $this->registerBaseTemplateRoot();
    }

    private function registerBaseTemplateRoot(): void
    {
        Event::on(
            View::class,
            View::EVENT_REGISTER_CP_TEMPLATE_ROOTS,
            static function(RegisterTemplateRootsEvent $event): void {
                $event->roots['jalendport-base'] = __DIR__ . '/templates';
            },
        );
    }
}

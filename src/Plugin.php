<?php

namespace jalendport\base;

use Craft;
use craft\base\Plugin as CraftPlugin;
use craft\console\Application as ConsoleApplication;
use craft\events\RegisterTemplateRootsEvent;
use craft\web\Application as WebApplication;
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

    /**
     * Returns the names of the settings currently overridden in
     * `config/<handle>.php`.
     *
     * Pass this to a settings template to disable the fields a config file has
     * taken control of — the companion to the `configWarning()` macro, which
     * explains *why* a field is disabled:
     *
     * ```php
     * return $app->getView()->renderTemplate('my-plugin/settings', [
     *     'settings' => $this->getSettings(),
     *     'overrides' => $this->getConfigOverrides(),
     * ]);
     * ```
     *
     * @return string[] the overridden setting names
     * @since 1.1.0
     */
    public function getConfigOverrides(): array
    {
        /** @var WebApplication|ConsoleApplication $app */
        $app = Craft::$app;

        return array_keys($app->getConfig()->getConfigFromFile($this->id));
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

<h1 align="center">Craft Base</h1>

<p align="center">The shared foundation under every <a href="https://github.com/jalendport">jalendport</a> Craft CMS plugin.</p>

## Features

- **Base Plugin class** — extend `jalendport\base\Plugin` instead of `craft\base\Plugin` and get everything below for free.
- **Per-plugin logging** — each plugin writes its own `storage/logs/<handle>-*.log`, with `MyPlugin::info()` / `::warning()` / `::error()` static helpers.
- **Controller traits** — `runAndReturn()` for web controllers (success/failure responses done right) and `runAndExit()` + output helpers for console controllers.
- **Settings helpers** — a `configWarning()` Twig macro that flags settings overridden in `config/<handle>.php`, plus `getConfigOverrides()` for disabling the fields a config file has taken control of.
- **Testing helpers** — settings factories and an in-memory cache for unit-only Pest suites.

## Usage

```php
use jalendport\base\Plugin;

class Altcha extends Plugin
{
    public static Altcha $plugin;

    public function init(): void
    {
        parent::init(); // registers the log target, @altcha alias, shared template root
        self::$plugin = $this;

        $this->registerEventHandlers();
    }
}
```

Flag and disable the settings a config file has overridden:

```php
protected function settingsHtml(): ?string
{
    return Craft::$app->getView()->renderTemplate('altcha/settings', [
        'settings' => $this->getSettings(),
        'overrides' => $this->getConfigOverrides(),
    ]);
}
```

```twig
{% import 'jalendport-base/_macros' as base %}

{{ forms.lightswitchField({
    label: 'Enabled'|t('altcha'),
    name: 'enabled',
    on: settings.enabled,
    disabled: 'enabled' in overrides,
    warning: base.configWarning('enabled', 'altcha'),
}) }}
```

## Support

Found a bug or have a question? [Open an issue](https://github.com/jalendport/craft-base/issues).

---

<p align="center">Made by <a href="https://jalendport.com">Jalen Davenport</a></p>

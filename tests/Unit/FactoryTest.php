<?php

declare(strict_types=1);

use jalendport\base\testing\Factory;
use yii\caching\ArrayCache;

class FactoryTestSettings
{
    public bool $enabled = false;
    public string $label = '';
}

test('settings() builds a settings object with overridden attributes', function(): void {
    $settings = Factory::settings(FactoryTestSettings::class, [
        'enabled' => true,
        'label' => 'Hello',
    ]);

    expect($settings)->toBeInstanceOf(FactoryTestSettings::class)
        ->and($settings->enabled)->toBeTrue()
        ->and($settings->label)->toBe('Hello');
});

test('settings() leaves defaults alone when no overrides are given', function(): void {
    $settings = Factory::settings(FactoryTestSettings::class);

    expect($settings->enabled)->toBeFalse()
        ->and($settings->label)->toBe('');
});

test('cache() returns a fresh in-memory cache', function(): void {
    $cache = Factory::cache();

    expect($cache)->toBeInstanceOf(ArrayCache::class);

    $cache->set('key', 'value');
    expect($cache->get('key'))->toBe('value');
    expect(Factory::cache()->get('key'))->toBeFalse();
});

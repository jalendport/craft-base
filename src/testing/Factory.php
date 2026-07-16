<?php

namespace jalendport\base\testing;

use yii\caching\ArrayCache;

/**
 * Small helpers for the unit-only Pest suites: settings models with
 * overridden attributes, and an in-memory cache stand-in — no Craft app needed.
 */
class Factory
{
    /**
     * @template T of object
     * @param class-string<T> $class
     * @param array<string,mixed> $attributes
     * @return T
     */
    public static function settings(string $class, array $attributes = []): object
    {
        $settings = new $class();

        foreach ($attributes as $name => $value) {
            $settings->$name = $value;
        }

        return $settings;
    }

    public static function cache(): ArrayCache
    {
        return new ArrayCache();
    }
}

<?php

namespace jalendport\base;

use Craft;
use craft\log\MonologTarget;
use Monolog\Formatter\LineFormatter;
use Psr\Log\LogLevel;
use ReflectionClass;
use yii\log\Logger;

/**
 * Per-plugin file logging.
 *
 * registerLogTarget() (called by the base Plugin's init()) routes everything
 * logged under the plugin's namespace or handle to storage/logs/<handle>-*.log.
 * The static helpers let call sites write `MyPlugin::error('…')` with the
 * category derived from the caller automatically.
 */
trait LogTrait
{
    /**
     * @param array<string,mixed> $params optional Craft::t() params for the message
     */
    public static function info(string $message, array $params = []): void
    {
        self::logMessage(Logger::LEVEL_INFO, $message, $params);
    }

    /**
     * @param array<string,mixed> $params optional Craft::t() params for the message
     */
    public static function warning(string $message, array $params = []): void
    {
        self::logMessage(Logger::LEVEL_WARNING, $message, $params);
    }

    /**
     * @param array<string,mixed> $params optional Craft::t() params for the message
     */
    public static function error(string $message, array $params = []): void
    {
        self::logMessage(Logger::LEVEL_ERROR, $message, $params);
    }

    protected function registerLogTarget(): void
    {
        // The dispatcher can be absent in unit tests; don't explode there.
        $dispatcher = Craft::getLogger()->dispatcher;

        if ($dispatcher === null) {
            return;
        }

        $namespace = (new ReflectionClass($this))->getNamespaceName();

        $dispatcher->targets[$this->id] = new MonologTarget([
            'name' => $this->id,
            'categories' => [$namespace . '\\*', $this->id],
            'level' => LogLevel::INFO,
            'logContext' => false,
            'allowLineBreaks' => false,
            'formatter' => new LineFormatter(
                format: "%datetime% [%level_name%] %message%\n",
                dateFormat: 'Y-m-d H:i:s',
            ),
        ]);
    }

    /**
     * @param array<string,mixed> $params
     */
    private static function logMessage(int $level, string $message, array $params = []): void
    {
        if ($params !== [] && static::getInstance() !== null) {
            $message = Craft::t(static::getInstance()->id, $message, $params);
        }

        // Derive the category from the caller so call sites never pass __METHOD__.
        $trace = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 3)[2] ?? null;
        $category = isset($trace['class'], $trace['function'])
            ? $trace['class'] . '::' . $trace['function']
            : static::class;

        Craft::getLogger()->log($message, $level, $category);
    }
}

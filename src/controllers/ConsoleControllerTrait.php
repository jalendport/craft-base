<?php

declare(strict_types=1);

namespace jalendport\base\controllers;

use Throwable;
use yii\console\ExitCode;
use yii\helpers\Console;

/**
 * Helpers for console controllers. Use inside a craft\console\Controller subclass.
 */
trait ConsoleControllerTrait
{
    protected function writeLine(string $message): void
    {
        $this->stdout($message . PHP_EOL);
    }

    protected function writeSuccess(string $message): void
    {
        $this->stdout($message . PHP_EOL, Console::FG_GREEN);
    }

    protected function writeError(string $message): void
    {
        $this->stderr('Error: ', Console::BOLD, Console::FG_RED);
        $this->stderr($message . PHP_EOL);
    }

    /**
     * Runs the given action, writing errors out and returning the right exit code.
     */
    protected function runAndExit(callable $action, bool $profile = false): int
    {
        $startTime = microtime(true);

        try {
            $action();
        } catch (Throwable $e) {
            if ($profile) {
                $this->writeLine(sprintf('(Failed after %.3fs.)', microtime(true) - $startTime));
            }

            $this->writeError($e->getMessage());

            return ExitCode::UNSPECIFIED_ERROR;
        }

        if ($profile) {
            $this->writeLine(sprintf('(Completed in %.3fs.)', microtime(true) - $startTime));
        }

        return ExitCode::OK;
    }
}

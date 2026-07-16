<?php

namespace jalendport\base\controllers;

use Throwable;
use yii\web\Response;

/**
 * Helpers for CP/site controllers. Use inside a craft\web\Controller subclass.
 */
trait WebControllerTrait
{
    /**
     * Runs the given action and turns the outcome into the right response —
     * asSuccess()/asFailure() handle the accepts-JSON vs redirect dance.
     *
     * The callable may return an array of extra data for JSON responses.
     */
    protected function runAndReturn(callable $action, ?string $successMessage = null): ?Response
    {
        try {
            $result = $action();
        } catch (Throwable $e) {
            return $this->asFailure($e->getMessage());
        }

        return $this->asSuccess($successMessage, is_array($result) ? $result : []);
    }
}

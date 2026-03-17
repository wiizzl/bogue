<?php

namespace App\Controller\Trait;

trait LogsExceptionDetailsTrait
{
    protected function logExceptionDetails(\Throwable $exception, string $context): void
    {
        error_log(sprintf('[%s] %s: %s', $context, get_class($exception), $exception->getMessage()));
    }
}

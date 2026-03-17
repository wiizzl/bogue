<?php

namespace App\Controller\Trait;

trait LogsExceptionDetailsTrait
{
    protected function logExceptionDetails(\Throwable $exception, string $context): void
    {
        $details = sprintf('[%s] %s', $context, (string) $exception);

        error_log($details);

        if (method_exists($this, 'addFlash')) {
            $this->addFlash('__console_error', $details);
        }
    }
}

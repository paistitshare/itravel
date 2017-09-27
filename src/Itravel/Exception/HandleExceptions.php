<?php

namespace Itravel\Exception;

use Itravel\View\View;

class HandleExceptions
{

    /**
     * Exception handler.
     *
     * @param \Exception $exception
     *
     * @return void
     */
    public static function handleException($exception)
    {
        $code = $exception->getCode();

        http_response_code($code);

        $log = dirname(__DIR__) . '/logs/' . date('Y-m-d') . '.txt';
        ini_set('error_log', $log);

        $message = "Uncaught exception: '" . get_class($exception) . "'";
        $message .= " with message '" . $exception->getMessage() . "'";
        $message .= "\nStack trace: " . $exception->getTraceAsString();
        $message .= "\nThrown in '" . $exception->getFile() . "' on line " . $exception->getLine();

        error_log($message);

        View::renderTwig("$code.html");

    }

    /**
     * Convert PHP errors to ErrorException instances.
     *
     * @param  int $level
     * @param  string $message
     * @param  string $file
     * @param  int $line
     * @param  array $context
     * @return void
     *
     * @throws \ErrorException
     */
    public static function handleError($level, $message, $file = '', $line = 0)
    {
        if (error_reporting() & $level) {
            throw new \ErrorException($message, 0, $level, $file, $line);
        }
    }

    /**
     * Handle an uncaught exception from the application.
     *
     * Note: Most exceptions can be handled via the try / catch block in
     * the HTTP and Console kernels. But, fatal error exceptions must
     * be handled differently since they are not normal exceptions.
     *
     * @param  \Throwable $e
     * @return void
     */
    public function handleExceptions($e)
    {
        if (!$e instanceof Exception) {
            $e = new FatalThrowableError($e);
        }
    }

}
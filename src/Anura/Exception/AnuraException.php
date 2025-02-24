<?php
declare(strict_types=1);
namespace Anura\Exception;

/**
 * Base exception class for Anura SDK.
 */
class AnuraException extends \Exception
{
    public function __construct($message, $code = 0, \Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
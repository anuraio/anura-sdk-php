<?php
declare(strict_types=1);
namespace Anura\Exceptions;

/**
 * Thrown when a 5XX response is returned from the Anura Direct API.
 */
class AnuraServerException extends AnuraException
{
    public function __construct($message, $code = 0, \Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
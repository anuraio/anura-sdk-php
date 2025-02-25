<?php
declare(strict_types=1);
namespace Anura\Exception;

/**
 * Thrown when a 4XX response is returned from the Anura Direct API.
 */
class AnuraClientException extends AnuraException
{
    public function __construct($message, $code = 0, \Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
<?php

namespace Soldo\Error;

class FailedStandardAuthenticationException extends FailedRequestException
{
    public function __construct(string $message = 'Authentication failed', $code = null, $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}

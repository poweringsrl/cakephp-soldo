<?php

namespace Soldo\Error;

use Cake\Core\Exception\Exception;

class FailedRequestException extends Exception
{
    public function __construct(string $message = 'Request failed', $code = null, $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}

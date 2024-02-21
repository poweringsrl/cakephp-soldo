<?php

namespace Soldo\Error;

use Cake\Core\Exception\Exception;

class InvalidFingerprintException extends Exception
{
    public function __construct(string $message = 'Invalid fingerprint', $code = null, $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}

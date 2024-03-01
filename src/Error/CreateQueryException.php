<?php

namespace Soldo\Error;

use Cake\Core\Exception\Exception;

class CreateQueryException extends Exception
{
    public function __construct(string $message = 'Error while generating the create query', $code = null, $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}

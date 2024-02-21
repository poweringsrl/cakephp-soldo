<?php

namespace Soldo\Error;

use Cake\Core\Exception\Exception;

class InvalidEnvironmentException extends Exception
{
    public function __construct(string $environment, $code = null, $previous = null)
    {
        parent::__construct('"' . strval($environment) . '" is not a valid environment. Use one of "production" or "demo"', $code, $previous);
    }
}

<?php

namespace Soldo\Core\Exception;

use Cake\Core\Exception\Exception;

class InvalidEnvironmentException extends Exception
{
    public function __construct($code = null, $previous = null)
    {
        parent::__construct('The "environment" parameter must be one of: \'live\', \'demo\'', $code, $previous);
    }
}

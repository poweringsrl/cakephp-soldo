<?php

namespace Soldo\Core\Exception;

use Cake\Core\Exception\Exception;

class FailedAuthenticationException extends Exception
{
    public function __construct($code = null, $previous = null)
    {
        parent::__construct('Soldo authentication failed', $code, $previous);
    }
}

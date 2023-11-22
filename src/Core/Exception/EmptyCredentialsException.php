<?php

namespace Soldo\Core\Exception;

use Cake\Core\Exception\Exception;

class EmptyCredentialsException extends Exception
{
    public function __construct($code = null, $previous = null)
    {
        parent::__construct('Both "client_id" and "client_secret" are required', $code, $previous);
    }
}

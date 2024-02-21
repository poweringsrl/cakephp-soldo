<?php

namespace Soldo\Error;

use Cake\Core\Exception\Exception;

class NoStandardCredentialsException extends Exception
{
    public function __construct($code = null, $previous = null)
    {
        parent::__construct('One or both of the client_id and client_secret were not provided', $code, $previous);
    }
}

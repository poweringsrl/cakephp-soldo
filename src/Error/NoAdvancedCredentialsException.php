<?php

namespace Soldo\Error;

use Cake\Core\Exception\Exception;

class NoAdvancedCredentialsException extends Exception
{
    public function __construct($code = null, $previous = null)
    {
        parent::__construct('One or both of the token and private key needed for the advanced authentication were not provided', $code, $previous);
    }
}

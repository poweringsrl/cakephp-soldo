<?php

namespace Soldo\Http\Client\Adapter;

use Cake\Http\Client\Adapter\Curl;
use Cake\Http\Client\Request;

class SoldoCurl extends Curl
{
    private string $_token;

    public function __construct(string $token)
    {
        $this->_token = $token;
    }

    public function buildOptions(Request $request, array $options)
    {
        $request->header('Authorization', 'Bearer ' . $this->_token);

        return parent::buildOptions($request, $options);
    }
}

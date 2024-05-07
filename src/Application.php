<?php

use Cake\Http\BaseApplication;

class Application extends BaseApplication
{
    public function bootstrap()
    {
        $this->addPlugin('Muffin/Webservice', ['bootstrap' => true]);
    }

    public function middleware($middleware)
    {
        return $middleware;
    }
}

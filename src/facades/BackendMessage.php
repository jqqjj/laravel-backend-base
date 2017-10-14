<?php


namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class BackendMessage extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'backend_response_message';
    }
}
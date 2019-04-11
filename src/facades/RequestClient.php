<?php


namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class RequestClient extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'request_client';
    }
}
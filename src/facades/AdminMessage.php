<?php


namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class AdminMessage extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'admin_response_message';
    }
}
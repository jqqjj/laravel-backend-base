<?php


namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class Documents extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'documents';
    }
}
<?php


namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class Referer extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'referer';
    }
}
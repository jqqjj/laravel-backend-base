<?php


namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class Human extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'human';
    }
}
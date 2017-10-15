<?php


namespace App\Helpers;

use Jqqjj\EasyHumanAuth\Manager;
use Jqqjj\EasyHumanAuth\Adapter\DBTableGateway;
use Illuminate\Support\Facades\DB;

class Human
{
    public function check()
    {
        $pdo = DB::connection()->getPdo();
        $adapter = new DBTableGateway($pdo);
        $manager = new Manager($adapter);
        
        return $manager->check();
    }
}
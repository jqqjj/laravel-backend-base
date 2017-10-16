<?php


namespace App\Helpers;

use Jqqjj\EasyHumanAuth\Manager;
use Jqqjj\EasyHumanAuth\Adapter\DBTableGateway;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cookie;

class Human
{
    private $manager;
    
    public function __construct()
    {
        $pdo = DB::connection()->getPdo();
        $adapter = new DBTableGateway($pdo);
        $this->manager = new Manager($adapter,Cookie::get(Manager::$cookie_key));
        $this->queueCookie();
    }
    
    public function check()
    {
        return $this->manager->check();
    }
    
    public function attempt($status=false)
    {
        if($status){
            return $this->manager->attemptSuccess();
        }else{
            return $this->manager->attemptFailure();
        }
    }
    
    public function queueCookie()
    {
        Cookie::queue(
                Manager::$cookie_key,
                $this->manager->getHandshake()->getId(),
                sprintf("%.2f", $this->manager->lifttime/60),
                $this->manager->path,
                $this->manager->domain,
                $this->manager->secure,
                $this->manager->httponly
            );
    }
}
<?php


namespace App\Helpers;

use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;

class Referer
{
    private $_referer = "";
    
    public function __construct($base="")
    {
        if(!empty($base)){
            $this->match($base);
        }
    }
    
    public function match($base)
    {
        $this->_referer = $this->fetchRequestReferer($base) ? : ($this->fetchServerReferer($base) ? : $base);
        return $this->_referer;
    }
    
    private function fetchRequestReferer($base)
    {
        $referer = Request::input("_referer");
        return ($base=="*" && !empty($referer)) || $this->routesCompare($referer, $base) ? $referer : null;
    }
    
    private function fetchServerReferer($base)
    {
        $referer = Request::server("HTTP_REFERER");
        return ($base=="*" && !empty($referer)) || $this->routesCompare($referer, $base) ? $referer : null;
    }
    
    private function routesCompare($route_path,$other_route_path)
    {
        if(empty($route_path) || empty($other_route_path)){
            return false;
        }
        
        try {
            $route_path_uri = Route::getRoutes()->match(Request::create($route_path))->getUri();
            $other_route_uri = Route::getRoutes()->match(Request::create($other_route_path))->getUri();
            return $route_path_uri == $other_route_uri;
        } catch (NotFoundHttpException $ex) {
            return false;
        }
        catch (MethodNotAllowedHttpException $ex){
            return false;
        }
    }
    
    public function __toString()
    {
        return $this->_referer;
    }
}
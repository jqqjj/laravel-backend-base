<?php


namespace App\Helpers;

use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;

class Referer
{
    public function get($referer,$default)
    {
        try {
            $source_path = Route::getRoutes()->match(Request::create($referer))->getUri();
            $default_path = Route::getRoutes()->match(Request::create($default))->getUri();
            return $source_path == $default_path ? $referer : $default;
        } catch (NotFoundHttpException $ex) {
            return $default;
        }
        catch (MethodNotAllowedHttpException $ex){
            return $default;
        }
    }
}
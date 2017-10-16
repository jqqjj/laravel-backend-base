<?php


namespace App\Helpers;

use Gregwar\Captcha\CaptchaBuilder;
use Illuminate\Support\Facades\Session;

class Captcha
{
    public function generate($path,$phrase=null)
    {
        $builder = new CaptchaBuilder($phrase);
        $builder->build();
        Session::put(config("backend.captcha_session_key_prefix").$path, $builder->getPhrase());
        ob_start();
        $builder->output();
        $content = ob_get_clean();
        return $content;
    }
    
    public function validate($path,$phrase)
    {
        if(!Session::exists(config("backend.captcha_session_key_prefix").$path) || empty($phrase)){
            return false;
        }
        return Session::get(config("backend.captcha_session_key_prefix").$path) == $phrase;
    }
}
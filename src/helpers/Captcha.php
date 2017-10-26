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
        $session_key = config("backend.captcha_session_key_prefix").$path;
        if(!Session::exists($session_key) || empty($phrase)){
            return false;
        }
        $captcha = Session::get($session_key);
        Session::forget($session_key);
        return $captcha == $phrase;
    }
}
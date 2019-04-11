<?php


namespace App\Helpers;

class RequestClient
{
    public function isWeixinBrowser()
    {
        return strpos(strtolower(request()->server("HTTP_USER_AGENT")),'micromessenger')!==false;
    }
    
    /*取得真实的IP*/
    public function realRemoteAddr()
    {
        $cdn_ip = request()->server("HTTP_ALI_CDN_REAL_IP");//七牛云使用的是ali cdn
        $default_ip = request()->server("REMOTE_ADDR");
        
        return !empty($cdn_ip) ? $cdn_ip : $default_ip;
    }
    
    public function isMobile()
    {
        $useragent = strtolower(request()->server('HTTP_USER_AGENT',""));
        
        return strpos($useragent, 'android')!==false || strpos($useragent, 'mobile')!==false || strpos($useragent, 'wap')!==false 
                || strpos($useragent, 'iphone')!==false || strpos($useragent, 'ipad')!==false ? true : false;
    }
    
    public function isDesktop()
    {
        $useragent = strtolower(request()->server('HTTP_USER_AGENT',""));
        
        return strpos($useragent, 'macintosh')!==false || strpos($useragent, 'x11')!==false || strpos($useragent, 'windows nt')!==false || strpos($useragent, 'msie')!==false ? true : false;
    }
    
    public function isSpider()
    {
        $useragent = strtolower(request()->server('HTTP_USER_AGENT',""));
        return strpos($useragent, 'spider')!==false || strpos($useragent, 'bot')!==false || strpos($useragent, 'slurp')!==false ? true : false;
    }
}
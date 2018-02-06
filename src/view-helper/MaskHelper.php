<?php

/**
 * 掩护
 */

namespace App\Http\ViewHelper;

class MaskHelper
{
    public function __construct()
    {
        
    }
    
    public function render($input)
    {
        $len = mb_strlen($input);
        $mask_len = max(min(4,$len-2),0);
        if($mask_len>0){
            return substr_replace($input, str_repeat("*", $mask_len), ceil(($len-$mask_len)/2), $mask_len);
        }else{
            return $input;
        }
    }
}
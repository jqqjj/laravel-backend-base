<?php


namespace App\Helpers;

class BytesFormat
{
    public function format($bytes, $precision=2)
    {
        if($bytes>1024*1024*1024){
            return sprintf("%.{$precision}f",$bytes / 1024 / 1024 / 1024) . " GB";
        }
        elseif($bytes>1024*1024){
            return sprintf("%.{$precision}f",$bytes / 1024 / 1024) . " MB";
        }
        elseif($bytes>1024){
            return sprintf("%.{$precision}f",$bytes / 1024) . " KB";
        }
        else{
            return $bytes . " B";
        }
    }
}
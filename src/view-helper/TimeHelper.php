<?php

/**
 * 日期/时间辅助
 */

namespace App\Http\ViewHelper;

class TimeHelper
{
    public function formatDate($date)
    {
        $time = strtotime($date);
        if(empty($time)){
            return "";
        }
        return date("Y-m-d",$time);
    }
}
<?php

/**
 * 列表排序
 */

namespace App\Http\ViewHelper;

use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Support\Facades\Input;

class SortHelper
{
    public function __construct()
    {
        
    }
    
    public function make(Paginator $paginator,$label,$column,$user_sort=null)
    {
        $params = (array)Input::get();
        $column_key = config("backend.list.column_key");
        $sort_key = config("backend.list.sort_key");
        $current_sort = $user_sort ?: config('backend.list.default_sort_type');
        //计算出sort方式,asc desc
        if(isset($params[$column_key]) && $params[$column_key]==$column){
            $sort = isset($params[$sort_key])&&in_array(strtolower($params[$sort_key]),['desc','asc']) ? 
                    array_values(array_diff(['desc','asc'],[strtolower($params[$sort_key])]))[0] : $current_sort;
            $class = $sort=='desc' ? "sort-asc" : "sort-desc";
        }else{
            $sort = $current_sort;
            $class = "no-sort";
        }
        
        $params[$column_key] = $column;
        $params[$sort_key] = $sort;
        
        $tmp_paginator = clone $paginator;
        $url = $tmp_paginator->appends($params)->url(1);
        $html = '<a class="c666" href="'.$url.'">'.$label.'<i class="sort '.$class.'"></i></a>';
        return $html;
    }
}
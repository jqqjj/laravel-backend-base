<?php


return [
    'list'=>[
        'column_key'=>'order',//列表排序的字段
        'sort_key'=>'sort',//列表排序的方式
        'default_sort_type'=>'desc',//默认排序方式
        'page_size'=>15,
    ],
    'captcha_session_key_prefix'=>'captcha_backend_',//验证码session索引前缀
    
    'helpers'=>[
        'sort'=>App\Http\ViewHelper\SortHelper::class,
        'admin'=>App\Http\ViewHelper\AdminHelper::class,
    ],
];
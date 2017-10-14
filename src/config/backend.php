<?php


return [
    'list'=>[
        'column_key'=>'order',//列表排序的字段
        'sort_key'=>'sort',//列表排序的方式
        'default_sort_type'=>'desc',//默认排序方式
        'page_size'=>15,
    ],
    'public_upload_path'=>'upload',//文件上传的目录
    
    'helpers'=>[
        'sort'=>App\Http\ViewHelper\SortHelper::class,
    ],
];
<?php


namespace App\Helpers;

use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Route;

class BackendResponseMessage
{
    public function success($msg,array $forward=[],array $links=[])
    {
        $forward_request = Request::create('admin/success-message', 'GET', array(
            'msg'=>$msg,
            '_forward'=>$forward,
            '_links'=>$links,
        ));
        //$original_input = Request::input();
        Request::replace($forward_request->input());
        //Request::replace($original_input->input());
        return Route::dispatch($forward_request);
    }
    
    public function warn($msg,array $forward=[],array $links=[])
    {
        $forward_request = Request::create('admin/warn-message', 'GET', array(
            'msg'=>$msg,
            '_forward'=>$forward,
            '_links'=>$links,
        ));
        //$original_input = Request::input();
        Request::replace($forward_request->input());
        //Request::replace($original_input->input());
        return Route::dispatch($forward_request);
    }
    
    public function error($msg,array $forward=[],array $links=[])
    {
        $forward_request = Request::create('admin/error-message', 'GET', array(
            'msg'=>$msg,
            '_forward'=>$forward,
            '_links'=>$links,
        ));
        //$original_input = Request::input();
        Request::replace($forward_request->input());
        //Request::replace($original_input->input());
        return Route::dispatch($forward_request);
    }
    
    public function json($code,$msg,$data=[])
    {
        return response()->json([
            'ret'=>$code,
            'message'=>$msg,
            'data'=>$data,
        ],200,[],JSON_UNESCAPED_UNICODE);
    }
}
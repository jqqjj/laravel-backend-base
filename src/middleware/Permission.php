<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use App\Facades\BackendMessage;

class Permission
{
    public function __construct()
    {
        
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $arg)
    {
        if (Auth::guard('backend')->guest()) {
            if ($request->expectsJson()) {
                return BackendMessage::json(401,"您未登录");
            } else {
                return BackendMessage::error('您未登录', ['label'=>'','url'=>route('adminlogin')]);
            }
        }
        
        if(!Auth::guard('backend')->user()->hasPermission($arg) && Auth::guard('backend')->id()!=1){
            if ($request->expectsJson()) {
                return BackendMessage::json(401,"权限不足");
            } else {
                return BackendMessage::error("权限不足");
            }
        }
        
        return $next($request);
    }
}

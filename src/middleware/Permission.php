<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use App\Facades\BackendMessage as Message;

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
            if ($request->ajax() || $request->wantsJson()) {
                return response('Unauthorized.', 401);
            } else {
                return redirect()->route('adminlogin');
            }
        }
        
        if(!Auth::guard('backend')->user()->hasPermission($arg) && Auth::guard('backend')->id()!=1){
            if ($request->ajax() || $request->wantsJson()) {
                return response('Unauthorized.', 401);
            } else {
                return Message::error("权限不足");
            }
        }
        
        return $next($request);
    }
}

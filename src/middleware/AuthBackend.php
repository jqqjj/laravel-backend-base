<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use App\Facades\BackendMessage;

class AuthBackend
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $guard)
    {
        $user = Auth::guard($guard)->user();
        if (empty($user)) {
            if ($request->expectsJson()) {
                return BackendMessage::json(401,"您未登录");
            } else {
                return redirect()->to(route('adminlogin'));
            }
        }
        if(!$user->enabled){
            Auth::guard($guard)->logout();
            if ($request->expectsJson()) {
                return BackendMessage::json(401,"账号被冻结");
            } else {
                return BackendMessage::error('账号被冻结', ['label'=>'','url'=>route('adminlogin')]);
            }
        }
        return $next($request);
    }
}

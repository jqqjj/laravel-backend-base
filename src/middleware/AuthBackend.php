<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use App\Facades\BackendMessage as Message;

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
            if ($request->ajax() || $request->wantsJson()) {
                return response('Unauthorized.', 401);
            } else {
                return redirect()->route('adminlogin');
            }
        }
        if(!$user->enabled){
            Auth::guard($guard)->logout();
            return Message::error('账号被冻结', ['label'=>'','url'=>route('adminlogin')]);
        }
        return $next($request);
    }
}

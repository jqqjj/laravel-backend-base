<?php

namespace App\Http\Middleware;

use Closure;
use App\Helpers\Permission as PermissionHelper;
use App\Facades\BackendMessage;

class Permission
{
    private $_permission;
    
    public function __construct(PermissionHelper $h_permission)
    {
        $this->_permission = $h_permission;
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
        if(!$this->_permission->has($arg)){
            if ($request->expectsJson()) {
                return BackendMessage::json(401,"权限不足");
            } else {
                return BackendMessage::error("权限不足");
            }
        }
        
        return $next($request);
    }
}

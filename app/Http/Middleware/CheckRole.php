<?php

namespace App\Http\Middleware;

use Closure;
class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        //Check's if we are logged in, if no, then 401
        if($request->user() === null) { 
            return redirect('/login');
        }  
        //getting from routes actions array
        $actions = $request->route()->getAction();
        //checking if route has roles (if route is aviable only for speficied users)
        $roles = isset($actions['roles']) ? $actions['roles'] : null;
        //if user has roles specified in route array or no routes are set up middleware will let you in
        if ($request->user()->hasAnyRole($roles) || !$roles) {
            return $next($request);
        }
        

        return response("insufficient permissions",401);

        //return redirect('/login')->with('status','insufficient permissions');

    }
}

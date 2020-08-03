<?php

namespace App\Http\Middleware;

use Closure;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */

    public function handle($request, Closure $next, ...$roles)
    {
        if ($request->user()->usertype === 'admin') {
            return $next($request);
        } else if (in_array($request->user()->role_id, $roles)) {
            return $next($request);
        }
        return redirect('/home')->with('status','you are not allowed to Admin Dashboard');
    }

}

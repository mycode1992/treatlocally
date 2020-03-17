<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (Auth::guard($guard)->check()) {
          //  return redirect('/home');
          $user= Auth::user();
          $user_id = $user->userid;
          $user_role_id = $user->role_id;
          if($user_role_id == '2'){
            return redirect('/merchant/myprofile');
            }
            else{
            return redirect('/dashboard');
            }
        }

        return $next($request);
    }
}

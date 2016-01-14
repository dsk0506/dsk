<?php

namespace App\Http\Middleware;

use Closure;
use Cookie;
use Redirect;
class Authenticate
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
        $path = $request->getPathInfo();
        $uid = cookie::get('uid');
        $redirectPath = cookie::get('redirectPath')?cookie::get('redirectPath'):'/';
        if(in_array($path,array('/login','/register','/loginDo','/registerDo')) && !empty($uid)){
            return redirect($redirectPath);
        }
        $pathArray = array('/send','/sendDo','/success');
        if(in_array($path,$pathArray) && empty($uid) ){
            return redirect("login");
        }

        return $next($request);
    }
}

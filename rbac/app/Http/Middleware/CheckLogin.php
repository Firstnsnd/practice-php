<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckLogin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
      @$http_referer = $_SERVER['HTTP_REFERER'];
      $admin = $request->session()->get('admin');
      if( $admin == '' || $admin['expire'] < time()){
          $request->session()->forget('admin');
          return redirect('/admin/login?return_url=' . urlencode($http_referer));
      }

      return $next($request);
    }
}

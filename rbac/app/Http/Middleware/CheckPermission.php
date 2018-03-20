<?php
namespace App\Http\Middleware;
use Closure;
use Illuminate\Http\Request;
use App\Handlers\M3Result;
class CheckPermission
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
      $URI = $request->getRequestUri();
      if(substr_count($URI, '/') == 4){
          $URI = substr($URI, 0, strrpos($URI, '/'));
      }
      if(session('privileage')!='*' && !in_array($URI, $request->session()->get('privileage'))){
			     return redirect('/admin/permission/noPermission');
		  }
      return $next($request);
    }
}

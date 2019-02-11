<?php

namespace App\Http\Middleware;

use Closure;
class Locale
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

    if ($request->method() === 'GET') {
        if($request->segment(1) == 'admin'){
            $segment = $request->segment(2);
            if (!in_array($segment, config('app.locales'))) {
                $segments = $request->segments();
                $fallback = session('locale') ?: config('app.fallback_locale');
                array_splice($segments, 1, 0, $fallback);

                return redirect()->to(implode('/', $segments));
            }
            session(['locale' => $segment]);
            app()->setLocale($segment);

        }else{
            $segment = $request->segment(1);
            if (!in_array($segment, config('app.locales'))) {
                $segments = $request->segments();
                $fallback = session('locale') ?: config('app.fallback_locale');
                $segments = array_prepend($segments, $fallback);

                return redirect()->to(implode('/', $segments));
            }
            session(['locale' => $segment]);
            app()->setLocale($segment);
        }

        return $next($request);
        }
    }
}
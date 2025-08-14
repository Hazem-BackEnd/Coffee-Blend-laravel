<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class CheckForPrice
{
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->is('products/checkout')) {
            if (!Session::has('price') || (float) Session::get('price') <= 0) {
                abort(403,'enta raye7 fe dahya');
            }
        }
        return $next($request);
    }
}

<?php

namespace App\Http\Middleware;

use Closure;
use Exception;

class isAdmin
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
        if($request->user()->level != 'admin') {
            // throw new Exception('Anda tidak berhak mengakses halaman ini', 0);
            return back()->with(['status' => 'error', 'msg' => 'Hayo! Mau Ngapain? Anda tidak berhak mengakses data tersebut.'], 403);
        }
        return $next($request);
    }
}

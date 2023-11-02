<?php

namespace App\Http\Middleware;

use App\Models\caja_chica;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class caja
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    { 
        
        if (Auth::check()) { 
            $caja_chica = caja_chica::where("user_id", auth()->user()->id)->where("is_abierto","Y")->first();
             
            if (is_null($caja_chica)) {
                session()->flash('warning', 'Aun no apertura la caja');
                return redirect()->route('caja.index');
            } else {
                return $next($request);
            } 
        }  
    }
}

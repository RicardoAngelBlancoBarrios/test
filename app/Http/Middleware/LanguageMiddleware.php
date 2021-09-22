<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App;

class LanguageMiddleware
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
        /*
        * If esta a true el valor de la variable status que tenemos en locale.php
        */
        
        if (config('locale.status')) {
            if (session()->get('language')!= null) {
                if (in_array(session()->get('language'), array_keys(config('locale.languages')))) {
                    
                    /*
                     * Establece el locale de Laravel
                     */
                    App::setLocale(session()->get('language'));
                    

                    setlocale(LC_TIME, config('locale.languages')[session()->get('language')][1]);

                    Carbon::setLocale(config('locale.languages')[session()->get('language')][0]);
                }
            }
        }
        return $next($request);
    }
}

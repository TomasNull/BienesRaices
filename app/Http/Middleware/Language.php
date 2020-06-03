<?php

namespace App\Http\Middleware;

use Closure;
use Carbon\Carbon;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class Language
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
        if (session('applocale')) {
            $configLanguage = config('languages')[session('applocale')];
            setlocale(LC_TIME, $configLanguage[1] . '.utf8');
            Carbon::setLocale(session('applocale')); /** Las fechas tendrán el formato para el idioma indicado */
            App::setLocale(Session::get('applocale')); /** Se establece el idioma de la aplicación */
        } else {
            session()->put('applocale', config('app.fallback_locale'));
            setlocale(LC_TIME, 'es_ES.utf8');
            Carbon::setLocale(session('applocale'));
            App::setLocale(Session::get('app.fallback_locale'));
        }

        return $next($request);
    }
}

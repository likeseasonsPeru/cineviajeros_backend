<?php

namespace App\Http\Middleware;

use Closure;
class VerifyAccessKey
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
        // Obtenemos el api-key que el usuario envia
        $key = $request->headers->get('X-Authorization');
        $headers = apache_request_headers();
        // Si coincide con el valor almacenado en la aplicacion
        // la aplicacion se sigue ejecutando
        if (isset($key) && $key == env('API_KEY')) {
            return $next($request);
        } else {
            // Si falla devolvemos el mensaje de error
            return response()->json(['status' => 'failed', 'msg' => 'unauthorized', 'key' => $key , 'env' => env('API_KEY')]);
        }
    }
}

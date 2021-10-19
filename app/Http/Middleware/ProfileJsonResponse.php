<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class ProfileJsonResponse
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        //check if debug bar is enable
        if (!app()->bound('debugbar')) {
            return $response;
        }
        //profile the json response
        if ($response instanceof JsonResponse && $request->has('_debug')) {
//            $response->setData($response->getData(true) + [
//                    '_debugbar' => app('debugbar')->getData(),
//                ]);
            $response->setData([
                    '_debugbar' => Arr::only(app('debugbar')->getData(), 'queries'),
                ] + $response->getData(true));
        }

        return $response;
    }
}

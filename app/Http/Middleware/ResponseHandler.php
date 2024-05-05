<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

/**
 * Обработчик ответов
 */
class ResponseHandler
{
    /**
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Принудительно выставляет формат ответа как JSON
        $request->headers->set('Accept', 'application/json');

        $response = $next($request);

        $setData = 'setData';
        $getData = 'getData';
        // Проверка если вдруг пришел обычный Response вместо JsonResponse
        if ($response instanceof \Illuminate\Http\Response) {
            $setData = 'setContent';
            $getData = 'getContent';
        }

        if ($response->headers->get('content-type') === 'application/json') {
            $response->$setData(
                [
                    'data'    => $response->$getData(),
                    'runtime' => microtime(true) - LARAVEL_START,
                ]
            );
        }
        return $response;
    }
}

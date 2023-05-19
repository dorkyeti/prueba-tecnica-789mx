<?php

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\{JsonResponse, Response};

if (!function_exists('json')) {
    /**
     * Wrapper of JsonResponse, Returns json
     *
     * @param Any $data
     * @param int $status
     * @param array $headers
     * @param int $options
     * 
     * @return Response
     **/
    function json($data = [], int $status = 200, array $headers = [], int $options = 0, $json = false): JsonResponse
    {
        if ($data instanceof Model && $data->wasRecentlyCreated) $status = 201;

        return new JsonResponse($data, $status, $headers, $options, $json);
    }
}

if (!function_exists('not_found')) {
    /**
     * Returns 404 error code
     *
     * @param string $message
     * @return Response
     **/
    function not_found(string $message = 'Recurso no encontrado'): Response
    {
        return json(compact('message'), 404);
    }
}

if (!function_exists('nothing')) {
    /**
     * Say nothing and returns a response with a 204 http code
     *
     * @return Response
     **/
    function nothing(): Response
    {
        return response()->noContent();
    }
}

if (!function_exists('random_bool')) {
    /**
     * Generate a random boolean value
     *
     * @return bool
     **/
    function random_bool(): bool
    {
        return (bool) random_int(0, 1);
    }
}

if (!function_exists('routeIs')) {
    /**
     * 
     *
     * @param string $route
     * 
     * @return bool
     **/
    function routeIs(string $route): bool
    {
        return request()->routeIs($route);
    }
}

if (!function_exists('routeIsActive')) {
    /**
     * 
     *
     * @param string $route
     * @param string $activeClass
     * @param string $defaultClass
     * 
     * @return string
     **/
    function routeIsActive(string $route, string $activeClass = 'active', string $defaultClass = ''): string
    {
        return request()->routeIs($route) ? $activeClass : $defaultClass;
    }
}

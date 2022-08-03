<?php

namespace App\Http\Middleware;

use Exception;

class Queue
{

    private static $default = [];
    private static $map = [];

    //FILA DE MIDDLEWARES
    private $middlewares = [];

    //CONTROLLER
    private $controller;

    //ARGUMENTOS
    private $controllerArgs = [];

    public function __construct($middlewares, $controller, $controllerArgs)
    {
        $this->middlewares = array_merge(self::$default, $middlewares);
        $this->controller = $controller;
        $this->controllerArgs = $controllerArgs;
    }

    public static function setMap($map)
    {
        self::$map = $map;
    }
    public static function setDefault($default)
    {
        self::$default = $default;
    }

    public function next($request)
    {

        //VERIFICA SE A FILA ESTA VAZIA
        if (empty($this->middlewares)) return call_user_func_array($this->controller, $this->controllerArgs);

        //MIDDLEWARES
        $middleware = array_shift($this->middlewares);

        //VERIFICA O MAPEAMENTO
        if (!isset(self::$map[$middleware])) {
            throw new Exception("Problemas ao processar o Middleware solicitado", 500);
        }

        //NEXT
        $queue = $this;
        $next = function ($request) use ($queue) {
            return $queue->next($request);
        };

        //EXECUTA O MIDDLEWARE
        return (new self::$map[$middleware])->handle($request, $next);
    }
}

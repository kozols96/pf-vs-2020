<?php


namespace Project\Components;


use mysql_xdevapi\Exception;
use Project\Controllers\ErrorController;

class Router
{

    private array $routes;

    private string $path;

    /**
     * Router constructor.
     * @param array $routes
     * @param string $path
     */
    public function __construct(array $routes, string $path)
    {
        $this->routes = $routes;
        $this->path = $path;
    }

    /**
     * @throws Exception
     */
    public function resolve(): void
    {
        $route = $this->routes[$this->path] ?? new Route(ErrorController::class, 'notFound');

        if (!method_exists($route->getControllerClass(), $route->getAction())) {
            throw new Exception("Action '{$route->getAction()}' 
            not found in '{$route->getControllerClass()}'");
        }

        echo call_user_func([$route->getControllerClass(), $route->getAction()]);
    }
}
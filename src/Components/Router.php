<?php


namespace Project\Components;


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

    public function resolve(): void
    {
        $route = $this->routes[$this->path] ?? new Route(ErrorController::class, 'notFound');

        echo call_user_func([$route->getControllerClass(), $route->getAction()]);
    }
}
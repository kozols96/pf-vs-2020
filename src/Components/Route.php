<?php


namespace Project\Components;


class Route
{

    private string $controllerClass;
    private string $action;

    /**
     * Route constructor.
     * @param string $controllerClass
     * @param string $action
     */
    public function __construct(string $controllerClass, string $action)
    {
        $this->controllerClass = $controllerClass;
        $this->action = $action;
    }

    public function getControllerClass(): string
    {
        return $this->controllerClass;
    }

    public function getAction(): string
    {
        return $this->action;
    }
}
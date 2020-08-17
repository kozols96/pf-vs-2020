<?php


namespace Project\Components;


class Route
{

    public const METHOD_GET = 'GET';
    public const METHOD_POST = 'POST';

    private string $controllerClass;
    private string $action;
    private array $allowedMethods;

    /**
     * Route constructor.
     * @param string $controllerClass
     * @param string $action
     * @param array $allowedMethods
     */
    public function __construct(string $controllerClass, string $action, array $allowedMethods = [])
    {

        $this->controllerClass = $controllerClass;
        $this->action = $action;
        $this->allowedMethods = $allowedMethods;
    }

    public function getControllerClass(): string
    {

        return $this->controllerClass;
    }

    public function getAction(): string
    {

        return $this->action;
    }

    public function getAllowedMethods(): array
    {

        return $this->allowedMethods;
    }
}
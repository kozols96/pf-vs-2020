<?php


namespace Project\Components;


abstract class Controller
{
    public function view(string $name, array $data = []): string
    {
        // TODO: Creates new View class, collects data, returns view

        return (new View($name, $data))->render();
    }
}
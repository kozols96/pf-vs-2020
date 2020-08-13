<?php


namespace Project\Controllers;


class ErrorController
{

    public function notFound(): string
    {
        return '404 not found';
    }
}
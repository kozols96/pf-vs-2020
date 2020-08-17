<?php


namespace Project\Controllers;

use Project\Components\Controller;

class ErrorController extends Controller
{

    public function forbidden(): string
    {

        return $this->view('error/403');
    }

    public function notFound(): string
    {

        return $this->view('error/404');
    }

    public function methodNotAllowed(): string
    {

        return $this->view('error/405');
    }
}
<?php


namespace Project\Controllers;

use Project\Components\Controller;

class ErrorController extends Controller
{

    public function notFound(): string
    {
        return $this->view('error/404');
    }
}
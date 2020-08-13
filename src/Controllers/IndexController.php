<?php


namespace Project\Controllers;

use Project\Components\Controller;

class IndexController extends Controller
{

    public function index(): string
    {
        return 'Hello world!';
    }
}
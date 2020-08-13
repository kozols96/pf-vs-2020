<?php


namespace Project\Controllers;

use Project\Components\Controller;

class AuthController extends Controller
{
    public function login(): string
    {
        return $this->view('login');
    }

    public function register(): string
    {
        return $this->view('register');
    }

    public function logout(): string
    {
        return 'logout';
    }
}
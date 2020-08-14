<?php


namespace Project\Controllers;

use Project\Components\ActiveUser;
use Project\Components\Controller;

class IndexController extends Controller
{

    public function index(): string
    {
        return $this->view('index');
    }

    public function dashboard(): ?string
    {

        if (!ActiveUser::isLoggedIn()) {
            return $this->redirect('/login');
        }

        return $this->view('dashboard', ['user' => ActiveUser::getUser()]);
    }
}
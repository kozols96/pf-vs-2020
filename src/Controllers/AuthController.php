<?php


namespace Project\Controllers;

use Project\Components\Controller;
use Project\Services\UserService;
use Project\Structures\UserRegisterItem;

class AuthController extends Controller
{

    private UserService $userService;

    /**
     * AuthController constructor.
     * @param UserService $userService
     */
    public function __construct(UserService $userService = null)
    {
        $this->userService = $userService ?? new UserService();
    }


    public function login(): string
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            var_dump($_POST);
        }

        return $this->view('login');
    }

    public function register(): string
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->userService->signUp(UserRegisterItem::fromArray($_POST));
        }

        return $this->view('register');
    }

    public function logout(): string
    {
        return 'logout';
    }
}
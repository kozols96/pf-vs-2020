<?php

use Project\Components\Route;
use Project\Controllers\AdminController;
use Project\Controllers\AuthController;
use Project\Controllers\IndexController;
use Project\Controllers\QuizRpcController;

return [
    '/' => new Route(IndexController::class, 'index',),
    '/login' => new Route(AuthController::class, 'login',),
    '/sign-up' => new Route(AuthController::class, 'register',),
    '/logout' => new Route(AuthController::class, 'logout',),
    '/dashboard' => new Route(IndexController::class, 'dashboard',),
    '/admin' => new Route(AdminController::class, 'index',),
    '/admin/view-user' => new Route(AdminController::class, 'viewUser', [Route::METHOD_GET]),
    '/admin/delete-user' => new Route(AdminController::class, 'deleteUser', [Route::METHOD_POST]),
    '/admin/toggle-user-admin' => new Route(AdminController::class, 'toggleUserAdmin', [Route::METHOD_POST]),
    '/quiz-rpc/get-all' => new Route(QuizRpcController::class, 'getAll'),
];

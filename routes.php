<?php

use Project\Components\Route;
use Project\Controllers\AuthController;
use Project\Controllers\IndexController;

return [
    '/' => new Route(IndexController::class, 'index'),
    '/login' => new Route(AuthController::class, 'login'),
    '/sign-up' => new Route(AuthController::class, 'register'),
];

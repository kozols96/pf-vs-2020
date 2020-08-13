<?php

use Project\Components\Route;
use Project\Controllers\AuthController;
use Project\Controllers\IndexController;

return [
    '/' => new Route(IndexController::class, 'index'),
    '/auth/login' => new Route(AuthController::class, 'login'),
];

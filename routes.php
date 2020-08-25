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
    '/admin/view-quiz' => new Route(AdminController::class, 'viewQuiz', [Route::METHOD_GET]),
    '/admin/view-question' => new Route(AdminController::class, 'viewQuestion', [Route::METHOD_GET]),
    '/admin/add/quiz' => new Route(AdminController::class, 'addQuiz'),
    '/admin/add/question' => new Route(AdminController::class, 'addQuestion'),
    '/admin/add/answer' => new Route(AdminController::class, 'addAnswer'),
    '/admin/edit/quiz' => new Route(AdminController::class, 'editQuiz'),
    '/admin/edit/question' => new Route(AdminController::class, 'editQuestion'),
    '/admin/edit/answer' => new Route(AdminController::class, 'editAnswer'),
    '/quiz-rpc/get-all' => new Route(QuizRpcController::class, 'getAll'),
    '/quiz-rpc/start' => new Route(QuizRpcController::class, 'startQuiz'),
    '/quiz-rpc/get-question' => new Route(QuizRpcController::class, 'getQuestion'),
    '/quiz-rpc/save-answer' => new Route(QuizRpcController::class, 'saveAnswer'),
    '/quiz-rpc/get-results' => new Route(QuizRpcController::class, 'getResults'),
];

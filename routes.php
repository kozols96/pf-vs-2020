<?php

use Project\Components\Route;
use Project\Controllers\IndexController;

return [
    '/' => new Route(IndexController::class, 'index'),

];

<?php

use Project\Components\Route;
use Project\Components\Router;
use Project\Controllers\ErrorController;

require_once '../vendor/autoload.php';
require_once '../bootstrap/app.php';

$routes = require_once '../routes.php';
$path = parse_url($_SERVER['REQUEST_URI'])['path'];

(new Router($routes, $path))->resolve();

<?php

error_reporting(E_ALL);
error_reporting(-1);
ini_set('error_reporting', E_ALL);

use Project\Components\Router;
use Project\Components\Session;

require_once '../vendor/autoload.php';
require_once '../bootstrap/app.php';

$routes = require_once '../routes.php';
$path = parse_url($_SERVER['REQUEST_URI'])['path'];

if (
    $_SERVER['REQUEST_METHOD'] === 'POST'
    && $_POST['csrf'] != Session::getInstance()->getCsrf()
) {

    throw new Exception('Invalid CSRF');

}

(new Router($routes, $path))->resolve();

<?php

use Dotenv\Dotenv;
use Illuminate\Database\Capsule\Manager as Capsule;

defined('PROJECT_ROOT') or define('PROJECT_ROOT', dirname(__DIR__));
defined('PROJECT_LAYOUT_DIR') or define('PROJECT_LAYOUT_DIR', PROJECT_ROOT . '/resources/layouts');
defined('PROJECT_VIEW_DIR') or define('PROJECT_VIEW_DIR', PROJECT_ROOT . '/resources/views');

Dotenv::createImmutable(dirname(__DIR__))->load();

session_start();

$capsule = new Capsule();
$capsule->addConnection(
    [
        "driver" => "mysql",
        "host" => env('DB_HOST'),
        "database" => env('DB_NAME'),
        "username" => env('DB_USER'),
        "password" => env('DB_PASS'),
        "charset" => "utf8",
        "collation" => "utf8_unicode_ci",
    ]
);

//Make this Capsule instance available globally.
$capsule->setAsGlobal();

// Setup the Eloquent ORM.
$capsule->bootEloquent();
<?php

use Dotenv\Dotenv;
use Illuminate\Database\Capsule\Manager as Capsule;

Dotenv::createImmutable(dirname(__DIR__))->load();

$capsule = new Capsule();
$capsule->addConnection(
    [
        "driver" => "mysql",
        "host" => env('DB_HOST'),
        "database" => env('DB_NAME'),
        "username" => env('DB_USER'),
        "password" => env('DB_PASS'),
    ]
);

//Make this Capsule instance available globally.
$capsule->setAsGlobal();

// Setup the Eloquent ORM.
$capsule->bootEloquent();
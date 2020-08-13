<?php
use Dotenv\Dotenv;

require_once "./vendor/autoload.php";

Dotenv::createImmutable(__DIR__)->load();

return
    [
        'paths' => [
            'migrations' => '%%PHINX_CONFIG_DIR%%/db/migrations',
            'seeds' => '%%PHINX_CONFIG_DIR%%/db/seeds',
        ],
        'environments' => [
            'default_migration_table' => 'migrations',
            'default_environment' => 'development',
            'development' => [
                'adapter' => 'mysql',
                'host' => env('DB_HOST'),
                'name' => env('DB_NAME'),
                'user' => env('DB_USER'),
                'pass' => env('DB_PASS'),
                'port' => '3306',
                'charset' => 'utf8',
            ],
        ],
        'version_order' => 'creation',
    ];
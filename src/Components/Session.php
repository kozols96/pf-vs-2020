<?php


namespace Project\Components;


class Session
{

    public const KEY_USER_ID = 'user_id';

    private static ?Session $instance = null;

    public static function getInstance(): Session
    {
        if (!self::$instance) {

            self::$instance = new Session();

        }

        return self::$instance;
    }

    public function get(string $key, $default = null)
    {

        return $_SESSION[$key] ?? $default;
    }

    public function set(string $key, $value): void
    {

        $_SESSION[$key] = $value;
    }

    public function unset(string $key): void
    {

        unset($_SESSION[$key]);
    }

    public function regenerate(): void
    {
        session_regenerate_id();
    }

    public function destroy(): void
    {

        session_destroy();
    }
}
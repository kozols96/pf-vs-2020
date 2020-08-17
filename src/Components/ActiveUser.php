<?php


namespace Project\Components;


use Project\Models\UserModel;


class ActiveUser
{

    public static function isLoggedIn(): bool
    {

        return self::getUserId() !== null;
    }

    public static function getUserId(): ?int
    {

        return Session::getInstance()->get(Session::KEY_USER_ID);
    }

    /**
     * @return UserModel|null
     */
    public static function getUser(): ?UserModel
    {

        $userId = self::getUserId();

        if (!$userId) {

            return null;

        }

        /** @noinspection PhpIncompatibleReturnTypeInspection */
        return UserModel::query()->where('id', '=', $userId)->first();
    }
}
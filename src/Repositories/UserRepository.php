<?php


namespace Project\Repositories;


use Project\Models\UserModel;

class UserRepository
{

    public function checkIsEmailRegistered(string $email): bool
    {
        return UserModel::query()->where('email', '=', $email)->exists();
    }

    public function getUserByEmail(string $email): ?UserModel
    {
        /** @noinspection PhpIncompatibleReturnTypeInspection */
        return UserModel::query()->where('email', '=', $email)->first();
    }

    public function getUserById(int $id): ?UserModel
    {

        /** @noinspection PhpIncompatibleReturnTypeInspection */
        return UserModel::query()->where('id', '=', $id)->first();
    }

    public function saveModel(UserModel $user): UserModel
    {
        $user->save();

        return $user;
    }

    public function getAll()
    {
        return UserModel::all()->all();
    }
}
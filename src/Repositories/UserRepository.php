<?php


namespace Project\Repositories;


use Project\Models\UserModel;

class UserRepository
{

    public function checkIsEmailRegistered(string $email): bool
    {
        return UserModel::query()->where('email', '=', $email)->exists();
    }

    public function saveModel(UserModel $user): UserModel
    {
        $user->save();

        return $user;
    }
}
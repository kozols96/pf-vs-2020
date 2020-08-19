<?php


namespace Project\Repositories;


use Project\Models\UserQuizAttemptModel;

class UserQuizAttemptRepository
{

    public function saveModel(UserQuizAttemptModel $model): UserQuizAttemptModel
    {
        $model->save();

        return $model;

    }

    public function getById(int $id): ?UserQuizAttemptModel
    {

        /** @noinspection PhpIncompatibleReturnTypeInspection */
        return UserQuizAttemptModel::query()->where('id', '=', $id)->first();
    }
}
<?php

namespace Project\Repositories;

use Project\Models\UserQuizAttemptAnswerModel;

class UserQuizAttemptAnswerRepository
{
    public function saveModel(UserQuizAttemptAnswerModel $model): UserQuizAttemptAnswerModel
    {
        $model->save();

        return $model;
    }
}
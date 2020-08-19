<?php


namespace Project\Repositories;


use Project\Models\QuizModel;

class QuizRepository
{

    public function getAll()
    {
        return QuizModel::all()->all();
    }

    public function getById(int $quizId): ?QuizModel
    {

        /** @noinspection PhpIncompatibleReturnTypeInspection */
        return QuizModel::query()->where('id', '=', $quizId)->first();
    }
}
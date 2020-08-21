<?php


namespace Project\Repositories;


use Project\Models\QuizModel;

class QuizRepository
{

    public function getAll()
    {
        return QuizModel::all()->all();
    }

    public function getQuizByID(int $id): ?QuizModel
    {
        /** @noinspection PhpIncompatibleReturnTypeInspection */
        return QuizModel::query()->where('id', '=', $id)->first();
    }

    public function getById(int $quizId): ?QuizModel
    {

        /** @noinspection PhpIncompatibleReturnTypeInspection */
        return QuizModel::query()->where('id', '=', $quizId)->first();
    }

    public function saveQuiz(QuizModel $quiz)
    {

        $quiz->save();

        return $quiz;
    }

    public function checkIsQuizAdded(?string $name): bool
    {
        return QuizModel::query()->where('name', '=', $name)->exists();
    }
}
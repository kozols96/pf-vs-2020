<?php


namespace Project\Repositories;


use Project\Models\QuestionModel;

class QuestionRepository
{

    public function getByQuizIdAndOffset(int $quizId, int $offset): ?QuestionModel
    {

        /** @noinspection PhpIncompatibleReturnTypeInspection */
        return QuestionModel::query()
            ->where('quiz_id','=', $quizId)
            ->offset($offset)
            ->first();
    }
}
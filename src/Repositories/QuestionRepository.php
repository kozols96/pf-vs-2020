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

    public function getAll()
    {

        return QuestionModel::all()->all();
    }

    public function getQuestionById(int $id): ?QuestionModel
    {

        /** @noinspection PhpIncompatibleReturnTypeInspection */
        return QuestionModel::query()->where('id', '=', $id)->first();
    }

    public function checkIsQuestionAdded($title): bool
    {
        return QuestionModel::query()->where('title', '=', $title)->exists();
    }

    public function saveQuestion(QuestionModel $question)
    {
        $question->save();

        return $question;
    }

    public function updateQuestion(int $id, ?string $title)
    {
        return QuestionModel::query()->where('id', '=', $id)->update(['title' => $title]);
    }
}
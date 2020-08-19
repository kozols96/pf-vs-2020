<?php


namespace Project\Repositories;


use Project\Models\AnswerModel;

class AnswerRepository
{

    public function addAnswer(string $title)
    {

    }

    public function getAnswer(string $title, bool $isCorrect): ?AnswerModel
    {
        return null;
    }

    public function getById(int $answerId): ?AnswerModel
    {
        /** @noinspection PhpIncompatibleReturnTypeInspection */
        return AnswerModel::query()->where('id', '=', $answerId)->first();
    }
}
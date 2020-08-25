<?php


namespace Project\Repositories;


use Project\Models\AnswerModel;

class AnswerRepository
{

    public function getAnswerById(int $answerId): ?AnswerModel
    {
        /** @noinspection PhpIncompatibleReturnTypeInspection */
        return AnswerModel::query()->where('id', '=', $answerId)->first();
    }

    public function checkIsAnswerAdded(?string $title): bool
    {
        return AnswerModel::query()->where('title', '=', $title)->exists();
    }

    public function saveAnswer(AnswerModel $answer)
    {
        $answer->save();

        return $answer;
    }

    public function updateAnswer(int $id, ?string $title, ?bool $is_correct)
    {
        return AnswerModel::query()->where('id', '=', $id)->update(['title' => $title, 'is_correct' => $is_correct]);
    }
}
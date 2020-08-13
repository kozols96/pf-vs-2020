<?php


namespace Project\Services;


use Project\Models\AnswerModel;

class AnswerService
{

    public function addAnswer(string $title): AnswerModel
    {
        // TODO implement
        $answer = new AnswerModel();

        $answer->title = $title;

        return $answer;
    }
}
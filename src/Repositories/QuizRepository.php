<?php


namespace Project\Repositories;


use Project\Models\QuizModel;

class QuizRepository
{

    public function getQuiz(string $title): ?QuizModel
    {
        return null;
    }

    public function getAll()
    {
        return QuizModel::all()->all();
    }
}
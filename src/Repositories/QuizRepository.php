<?php


namespace Project\Repositories;


use Project\Models\QuizModel;

class QuizRepository
{

    public function getAll()
    {
        return QuizModel::all()->all();
    }
}
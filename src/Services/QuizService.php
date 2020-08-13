<?php
declare(strict_types=1);

namespace Project\Services;

use Project\Models\QuizModel;

class QuizService
{
    public function addQuiz(string $title): QuizModel
    {
        // TODO implement
        $quiz = new QuizModel();

        $quiz->title = $title;

        return $quiz;
    }

    public function beginTest(string $title): ?QuizModel
    {
        // TODO implement
        return null;
    }
}
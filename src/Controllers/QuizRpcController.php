<?php


namespace Project\Controllers;


use Project\Components\Controller;
use Project\Services\QuizServices;
use Project\Structures\QuizStructure;


class QuizRpcController extends Controller
{

    private QuizServices $quizService;

    /**
     * QuizRpcController constructor.
     * @param QuizServices|null $quizService
     */
    public function __construct(QuizServices $quizService = null)
    {
        $this->quizService = $quizService ?? new QuizServices();
    }

    public function getAll(): string
    {

        $quizzes = $this->quizService->getQuizDataStructures();

        return json_encode(
            [
                'success' => true,
                'quizData' => array_map( fn ($quizDatum) => $quizDatum->toArray(), $quizzes)
            ]
        );
    }
}
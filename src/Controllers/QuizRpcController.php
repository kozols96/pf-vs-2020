<?php


namespace Project\Controllers;


use Exception;
use Project\Components\ActiveUser;
use Project\Components\Controller;
use Project\Services\QuizServices;


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
                'quizData' => array_map(fn($quizDatum) => $quizDatum->toArray(), $quizzes),
            ]
        );
    }

    public function startQuiz(): string
    {

        $activeUserId = ActiveUser::getUserId();
        $quizId = (int)($_POST['quizId'] ?? null);

        $this->quizService->startQuiz($activeUserId, $quizId);

        return json_encode(
            [
                'success' => true,
            ]
        );
    }

    public function getQuestion(): string
    {

        $question = $this->quizService->getNextQuestionStructure();
        $isLastQuestion = $this->quizService->isLastQuestion();

        return json_encode(
            [
                'success' => true,
                'questionData' => $question->toArray(),
                'isLastQuestion' => $isLastQuestion,
            ]
        );
    }
}
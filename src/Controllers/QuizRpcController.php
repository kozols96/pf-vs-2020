<?php


namespace Project\Controllers;


use Project\Components\ActiveUser;
use Project\Components\Controller;
use Project\Services\QuizService;


class QuizRpcController extends Controller
{

    private QuizService $quizService;

    /**
     * QuizRpcController constructor.
     * @param QuizService|null $quizService
     */
    public function __construct(QuizService $quizService = null)
    {
        $this->quizService = $quizService ?? new QuizService();
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
                'questionData' => $question ? $question->toArray() : null,
                'isLastQuestion' => $isLastQuestion,
            ]
        );
    }

    public function saveAnswer(): string
    {
        $answerId = (int)($_POST['answerId'] ?? null);

        $this->quizService->saveAnswer($answerId);

        return json_encode(['success' => true]);
    }

    public function getResults(): string
    {
        [$correctAnswerCount, $totalQuestionCount] = $this->quizService->getResults();

        return json_encode(
            [
                'success' => true,
                'correctAnswerCount' => $correctAnswerCount,
                'totalQuestionCount' => $totalQuestionCount,
            ]
        );
    }
}
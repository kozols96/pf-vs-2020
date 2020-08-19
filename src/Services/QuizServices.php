<?php


namespace Project\Services;


use Project\Models\QuizModel;
use Project\Repositories\QuizRepository;
use Project\Structures\QuizStructure;

class QuizServices
{

    private QuizRepository $quizRepository;

    /**
     * QuizServices constructor.
     * @param QuizRepository|null $quizRepository
     */
    public function __construct(QuizRepository $quizRepository = null)
    {
        $this->quizRepository = $quizRepository ?? new QuizRepository();
    }

    /**
     * @return QuizStructure[]
     */
    public function getQuizDataStructures(): array
    {

        $quizModels = $this->quizRepository->getAll();

        $quizStructures = [];

        foreach ($quizModels as $quizModel) {

            $quizStructure = new QuizStructure();
            $quizStructure->id = $quizModel->id;
            $quizStructure->name = $quizModel->name;
            $quizStructure->questionCount = count($quizModel->questions);

            $quizStructures[] = $quizStructure;
        }

        return $quizStructures;
    }

    public function addQuiz(string $name): QuizModel
    {

        $quiz = new QuizModel();

    }
}
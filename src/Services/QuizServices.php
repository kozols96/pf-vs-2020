<?php


namespace Project\Services;


use Exception;
use Project\Components\Session;
use Project\Models\QuestionModel;
use Project\Models\QuizModel;
use Project\Models\UserQuizAttemptModel;
use Project\Repositories\QuestionRepository;
use Project\Repositories\QuizRepository;
use Project\Repositories\UserQuizAttemptRepository;
use Project\Structures\AnswerStructure;
use Project\Structures\QuestionStructure;
use Project\Structures\QuizStructure;

class QuizServices
{

    private QuizRepository $quizRepository;
    private Session $session;
    private UserQuizAttemptRepository $userQuizAttemptRepository;
    private QuestionRepository $questionRepository;
    /**
     * @var QuestionRepository
     */


    /**
     * QuizServices constructor.
     * @param QuizRepository|null $quizRepository
     * @param Session|null $session
     * @param QuestionRepository|null $questionRepository
     * @param UserQuizAttemptRepository|null $userQuizAttemptRepository
     */
    public function __construct(QuizRepository $quizRepository = null, Session $session = null, QuestionRepository $questionRepository = null, UserQuizAttemptRepository $userQuizAttemptRepository = null)
    {
        $this->quizRepository = $quizRepository ?? new QuizRepository();
        $this->session = $session ?? new Session();
        $this->userQuizAttemptRepository = $userQuizAttemptRepository ?? new UserQuizAttemptRepository();
        $this->questionRepository = $questionRepository ?? new QuestionRepository();
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

    /**
     * @param int $activeUserId
     * @param int $quizId
     * @throws Exception
     */
    public function startQuiz(int $activeUserId, int $quizId)
    {

        $quiz = $this->quizRepository->getById($quizId);

        if (!$quiz) {
            throw new Exception("Quiz not found");
        }

        $attempt = new UserQuizAttemptModel();
        $attempt->user_id = $activeUserId;
        $attempt->quiz_id = $quizId;

        $attempt = $this->userQuizAttemptRepository->saveModel($attempt);

        $this->session->set(Session::KEY_CURRENT_ATTEMPT_ID, $attempt->id);
        $this->session->set(Session::KEY_QUESTIONS_ANSWERED, 0);
    }

    public function getNextQuestionStructure(): ?QuestionStructure
    {
        $attemptId = $this->session->get(Session::KEY_CURRENT_ATTEMPT_ID);
        $attempt = $this->userQuizAttemptRepository->getById($attemptId);

        $quizId = $attempt->quiz_id;
        $questionsAnswered = $this->session->get(Session::KEY_QUESTIONS_ANSWERED);

        $questionModel = $this->questionRepository->getByQuizIdAndOffset($quizId, $questionsAnswered);
        if (!$questionModel) {
            return null;
        }

        $questionStructure = new QuestionStructure();
        $questionStructure->id = $questionModel->id;
        $questionStructure->quizId = $questionModel->quiz_id;
        $questionStructure->title = $questionModel->title;
        $questionStructure->answers = $this->getAnswerStructuresFromQuestion($questionModel);

        return $questionStructure;
    }

    public function isLastQuestion(): bool
    {

        $attemptId = $this->session->get(Session::KEY_CURRENT_ATTEMPT_ID);
        $questionsAnswered = $this->session->get(Session::KEY_QUESTIONS_ANSWERED);

        $attempt = $this->userQuizAttemptRepository->getById($attemptId);

        return ($questionsAnswered + 1) >= count($attempt->quiz->questions);
    }

    private function getAnswerStructuresFromQuestion(QuestionModel $questionModel): array
    {

        $answerStructures = [];
        foreach ($questionModel->answers as $answerModel) {
            $answerStructure = new AnswerStructure();
            $answerStructure->id = $answerModel->id;
            $answerStructure->questionId = $answerModel->question_id;
            $answerStructure->title = $answerModel->title;

            $answerStructures[] = $answerStructure;
        }

        return $answerStructures;
    }
}
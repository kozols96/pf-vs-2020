<?php


namespace Project\Services;


use Exception;
use Project\Components\Session;
use Project\Exceptions\AdminValidationException;
use Project\Models\QuestionModel;
use Project\Models\QuizModel;
use Project\Models\UserQuizAttemptAnswerModel;
use Project\Models\UserQuizAttemptModel;
use Project\Repositories\AnswerRepository;
use Project\Repositories\QuestionRepository;
use Project\Repositories\QuizRepository;
use Project\Repositories\UserQuizAttemptAnswerRepository;
use Project\Repositories\UserQuizAttemptRepository;
use Project\Structures\AnswerStructure;
use Project\Structures\QuestionAddItem;
use Project\Structures\QuestionStructure;
use Project\Structures\QuizAddItem;
use Project\Structures\QuizStructure;

class QuizServices
{
    private QuizRepository $quizRepository;
    private Session $session;
    private QuestionRepository $questionRepository;
    private UserQuizAttemptRepository $userQuizAttemptRepository;
    private AnswerRepository $answerRepository;
    private UserQuizAttemptAnswerRepository $userQuizAttemptAnswerRepository;

    /**
     * QuizServices constructor.
     * @param QuizRepository|null $quizRepository
     * @param Session|null $session
     * @param QuestionRepository|null $questionRepository
     * @param UserQuizAttemptRepository|null $userQuizAttemptRepository
     * @param AnswerRepository|null $answerRepository
     * @param UserQuizAttemptAnswerRepository|null $userQuizAttemptAnswerRepository
     */
    public function __construct(
        QuizRepository $quizRepository = null,
        Session $session = null,
        QuestionRepository $questionRepository = null,
        UserQuizAttemptRepository $userQuizAttemptRepository = null,
        AnswerRepository $answerRepository = null,
        UserQuizAttemptAnswerRepository $userQuizAttemptAnswerRepository = null
    ) {
        $this->quizRepository = $quizRepository ?? new QuizRepository();
        $this->session = $session ?? new Session();
        $this->questionRepository = $questionRepository ?? new QuestionRepository();
        $this->userQuizAttemptRepository = $userQuizAttemptRepository ?? new UserQuizAttemptRepository();
        $this->answerRepository = $answerRepository ?? new AnswerRepository();
        $this->userQuizAttemptAnswerRepository = $userQuizAttemptAnswerRepository ?? new UserQuizAttemptAnswerRepository(
            );
    }

    /**
     * @param int $id
     * @return QuizModel|null
     * @throws AdminValidationException
     */


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

    /**
     * @param QuizAddItem $quizAddItem
     * @return QuizModel
     * @throws AdminValidationException
     */


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

    public function saveAnswer(int $answerId): void
    {
        $attemptId = $this->session->get(Session::KEY_CURRENT_ATTEMPT_ID);
        $attempt = $this->userQuizAttemptRepository->getById($attemptId);
        $answerModel = $this->answerRepository->getById($answerId);
        if (!$answerModel) {
            throw new Exception("Answer not found!");
        }
        if ($attempt->quiz->id !== $answerModel->question->quiz->id) {
            throw new Exception("Answer from another quiz");
        }
        $attemptAnswerModel = new UserQuizAttemptAnswerModel();
        $attemptAnswerModel->attempt_id = $attempt->id;
        $attemptAnswerModel->question_id = $answerModel->question_id;
        $attemptAnswerModel->answer_id = $answerModel->id;
        $this->userQuizAttemptAnswerRepository->saveModel($attemptAnswerModel);
        $questionsAnswered = $this->session->get(Session::KEY_QUESTIONS_ANSWERED);
        $questionsAnswered++;
        $this->session->set(Session::KEY_QUESTIONS_ANSWERED, $questionsAnswered);
    }

    public function getResults(): array
    {
        $attemptId = $this->session->get(Session::KEY_CURRENT_ATTEMPT_ID);
        $attempt = $this->userQuizAttemptRepository->getById($attemptId);

        $completedQuiz = $attempt->quiz;
        $totalQuestionCount = count($completedQuiz->questions);

        $correctAnswerCount = 0;
        $userAnswers = $attempt->userAnswers;
        foreach ($userAnswers as $userAnswer) {
            $correctAnswerCount += $userAnswer->answer->is_correct;
        }

        $this->session->unset(Session::KEY_CURRENT_ATTEMPT_ID);
        $this->session->unset(Session::KEY_QUESTIONS_ANSWERED);

        return [$correctAnswerCount, $totalQuestionCount];
    }

    public function viewQuiz(int $id): ?QuizModel
    {
        if (!$id) {

            throw new AdminValidationException("Quiz ID missing");
        }


        $quiz = $this->quizRepository->getQuizById($id);


        if (!$quiz) {

            throw new AdminValidationException("Quiz with ID '{$id}' not found");
        }

        return $quiz;
    }

    /**
     * @param QuizAddItem $quizAddItem
     * @return QuizModel
     * @throws AdminValidationException
     */
    public function addQuiz(QuizAddItem $quizAddItem): QuizModel
    {

        $this->validateQuizItemOrFail($quizAddItem);

        $quiz = new QuizModel();
        $quiz->name = $quizAddItem->name;

        $quiz = $this->quizRepository->saveQuiz($quiz);

        return $quiz;

    }

    /**
     * @param QuizAddItem $quizAddItem
     * @throws AdminValidationException
     */
    private function validateQuizItemOrFail(QuizAddItem $quizAddItem)
    {

        $errors = [];

        if ($this->quizRepository->checkIsQuizAdded($quizAddItem->name)) {
            $errors[] = "Quiz with this name is already added";
        }

        if ($errors) {
            $exception = new AdminValidationException();
            $exception->errorMessage = $errors;

            throw $exception;
        }
    }

    /**
     * @param int $id
     * @return QuestionModel|null
     * @throws AdminValidationException
     */
    public function viewQuestion(int $id): ?QuestionModel
    {
        if (!$id) {
            throw new AdminValidationException("Quiz ID missing");
        }


        $question = $this->questionRepository->getQuestionById($id);


        if (!$question) {
            throw new AdminValidationException("Quiz with ID '{$id}' not found");
        }

        return $question;
    }

    /**
     * @param QuestionAddItem $questionAddItem
     * @return QuestionModel
     * @throws AdminValidationException
     */
    public function addQuestion(QuestionAddItem $questionAddItem, QuizModel $quiz)
    {
        $this->validateQuestionItemOrFail($questionAddItem);

        $question = new QuestionModel();
        $question->quiz_id = $quiz->id;
        $question->title = $questionAddItem->title;

        $question = $this->questionRepository->saveQuestion($question);

        return $question;
    }

    private function validateQuestionItemOrFail(QuestionAddItem $questionAddItem)
    {
        $errors = [];

        $id = (int)($_GET['id'] ?? null);

        if ($this->quizRepository->getById($id)) {
            if ($this->questionRepository->checkIsQuestionAdded($questionAddItem->title)) {
                $errors[] = "Quiz with this name is already added";
            }
        }
        if ($errors) {
            $exception = new AdminValidationException();
            $exception->errorMessage = $errors;

            throw $exception;
        }
    }
}
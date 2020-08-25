<?php

namespace Project\Controllers;

use Project\Components\ActiveUser;
use Project\Components\Controller;
use Project\Components\Session;
use Project\Exceptions\AdminValidationException;
use Project\Exceptions\Http\HttpForbiddenException;
use Project\Exceptions\Http\HttpNotFoundException;
use Project\Repositories\AnswerRepository;
use Project\Repositories\QuestionRepository;
use Project\Repositories\QuizRepository;
use Project\Repositories\UserRepository;
use Project\Services\QuizService;
use Project\Services\UserService;
use Project\Structures\AnswerItem;
use Project\Structures\QuestionItem;
use Project\Structures\QuizItem;

class AdminController extends Controller
{

    private UserRepository $userRepository;
    private QuizRepository  $quizRepository;
    private QuestionRepository $questionRepository;
    private AnswerRepository $answerRepository;
    private UserService $userService;
    private QuizService $quizService;

    /**
     * AdminController constructor.
     * @param UserRepository|null $userRepository
     * @param QuizRepository|null $quizRepository
     * @param QuestionRepository|null $questionRepository
     * @param AnswerRepository|null $answerRepository
     * @param UserService|null $userService
     * @param QuizService|null $quizService
     */
    public function __construct(
        UserRepository $userRepository = null,
        QuizRepository $quizRepository = null,
        QuestionRepository $questionRepository = null,
        AnswerRepository $answerRepository = null,
        UserService $userService = null,
        QuizService $quizService = null
    ) {
        $this->userRepository = $userRepository ?? new UserRepository();
        $this->quizRepository = $quizRepository ?? new QuizRepository();
        $this->questionRepository = $questionRepository ?? new QuestionRepository();
        $this->answerRepository = $answerRepository ?? new AnswerRepository();
        $this->userService = $userService ?? new UserService();
        $this->quizService = $quizService ?? new QuizService();
    }

    /**
     * @return string|null
     * @throws HttpForbiddenException
     */
    public function index(): ?string
    {
        if (!ActiveUser::getUser()->is_admin) {
            throw new HttpForbiddenException();
        }

        $users = $this->userRepository->getAll();
        $quizzes = $this->quizRepository->getAll();

        return $this->view('admin/index', ['users' => $users, 'quizzes' => $quizzes]);
    }

    /**
     * @return string|null
     * @throws HttpForbiddenException
     */
    public function viewUser(): ?string
    {

        if (!ActiveUser::getUser()->is_admin) {

            throw new HttpForbiddenException();
        }

        $id = (int)($_GET['id'] ?? null);

        try {
            $user = $this->userService->viewUser($id, ActiveUser::getUserId());;
        } catch (AdminValidationException $exception) {
            Session::getInstance()->setErrorMessage($exception->getMessage());

            return $this->redirect('/admin');
        }

        return $this->view('admin/view-user', ['user' => $user]);
    }

    /**
     * @return string|null
     * @throws HttpForbiddenException
     */
    public function toggleUserAdmin(): ?string
    {
        if (!ActiveUser::getUser()->is_admin) {
            throw new HttpForbiddenException();
        }
        $id = (int)($_POST['id'] ?? null);

        try {
            $this->userService->toggleUserAdmin($id, ActiveUser::getUserId());
            Session::getInstance()->setSuccessMessage("User successfully toggled");
        } catch (AdminValidationException $exception) {
            Session::getInstance()->setErrorMessage($exception->getMessage());
        }

        return $this->redirect($_SERVER['HTTP_REFERER']);
    }

    /**
     * @return string|null
     * @throws HttpForbiddenException
     */
    public function deleteUser(): ?string
    {

        if (!ActiveUser::getUser()->is_admin) {
            throw new HttpForbiddenException();
        }

        $id = (int)($_POST['id'] ?? null);

        try {
            $this->userService->deleteUser($id, ActiveUser::getUserId());
            Session::getInstance()->setSuccessMessage("User successfully deleted");
        } catch (AdminValidationException $exception) {
            Session::getInstance()->setErrorMessage($exception->getMessage());
        }

        return $this->redirect($_SERVER['HTTP_REFERER']);
    }

    public function viewQuiz(): ?string
    {
        if (!ActiveUser::getUser()->is_admin) {
            throw new HttpForbiddenException();
        }

        $id = (int)($_GET['id'] ?? null);

        try {
            $quizzes = $this->quizService->viewQuiz($id);
        } catch (AdminValidationException $exception) {
            Session::getInstance()->setErrorMessage($exception->getMessage());

            return $this->redirect('/admin');
        }

        return $this->view('admin/view-quiz', ['quizzes' => $quizzes]);
    }

    /**
     * @return string|null
     * @throws HttpForbiddenException
     */
    public function addQuiz()
    {
        if (!ActiveUser::getUser()->is_admin) {
            throw new HttpForbiddenException();
        }

        $quizAddItem = QuizItem::fromArray($_POST);
        $errors = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            try {
                $this->quizService->addQuiz($quizAddItem);

                return $this->redirect('/admin');
            } catch (AdminValidationException $exception) {
                $errors = $exception->errorMessage;
            }
        }

        return $this->view('admin/add/quiz', ['quizAddItem' => $quizAddItem, 'errors' => $errors]);
    }

    public function editQuiz()
    {
        if (!ActiveUser::getUser()->is_admin) {
            throw new HttpForbiddenException();
        }

        $id = (int)($_GET['id'] ?? null);

        $quizItem = QuizItem::fromArray($_POST);

        $quiz = $this->quizRepository->getQuizByID($id);

        $errors = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                $this->quizService->editQuiz($quizItem, $quiz);
                return $this->redirect('/admin');
            } catch (AdminValidationException $exception) {
                $errors = $exception->errorMessage;
            }
        }

        return $this->view('admin/edit/quiz', ['quiz' => $quiz, 'quizItem' => $quizItem, 'errors' => $errors]);
    }

    public function viewQuestion(): ?string
    {
        if (!ActiveUser::getUser()->is_admin) {
            throw new HttpForbiddenException();
        }

        $id = (int)($_GET['id'] ?? null);

        try {
            $questions = $this->quizService->viewQuestion($id);
        } catch (AdminValidationException $exception) {
            Session::getInstance()->setErrorMessage($exception->getMessage());

            return $this->redirect('/admin');
        }

        return $this->view('admin/view-question', ['questions' => $questions]);
    }

    /**
     * @return string|null
     * @throws AdminValidationException
     * @throws HttpForbiddenException
     */
    public function addQuestion()
    {
        if (!ActiveUser::getUser()->is_admin) {
            throw new HttpForbiddenException();
        }

        $id = (int)($_GET['id'] ?? null);

        $questionAddItem = QuestionItem::fromArray($_POST);

        $errors = [];

        $quiz = $this->quizRepository->getQuizByID($id);

        if (!$quiz) {

            throw new HttpNotFoundException();

        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            try {
                $this->quizService->addQuestion($questionAddItem, $quiz);

                return $this->redirect('/admin/view-quiz?id=' . $id);
            } catch (AdminValidationException $exception) {
                $errors = $exception->errorMessage;
            }
        }

        return $this->view('admin/add/question', ['questionAddItem' => $questionAddItem, 'quiz' => $quiz, 'errors' => $errors]);
    }

    public function editQuestion()
    {
        if (!ActiveUser::getUser()->is_admin) {
            throw new HttpForbiddenException();
        }

        $id = (int)($_GET['id'] ?? null);

        $questionItem = QuestionItem::fromArray($_POST);

        $question = $this->questionRepository->getQuestionById($id);


        $errors = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                $this->quizService->editQuestion($questionItem, $question);
                return $this->redirect('/admin/view-quiz?id=' . $question->quiz_id);
            } catch (AdminValidationException $exception) {
                $errors = $exception->errorMessage;
            }
        }

        return $this->view('admin/edit/question', ['question' => $question, 'questionItem' => $questionItem, 'errors' => $errors]);
    }

    /**
     * @return string|null
     * @throws HttpForbiddenException
     */
    public function addAnswer()
    {
        if (!ActiveUser::getUser()->is_admin) {
            throw new HttpForbiddenException();
        }

        $id = (int)($_GET['id'] ?? null);

        $answerAddItem = AnswerItem::fromArray($_POST);
        $errors = [];

        $question = $this->questionRepository->getQuestionById($id);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            try {
                $this->quizService->addAnswer($answerAddItem, $question);

                return $this->redirect('/admin/view-question?id=' . $id);
            } catch (AdminValidationException $exception) {
                $errors = $exception->errorMessage;
            }
        }

        return $this->view('admin/add/answer', ['answerAddItem' => $answerAddItem, 'question' => $question, 'errors' => $errors]);
    }

    /**
     * @return string|null
     * @throws HttpForbiddenException
     */
    public function editAnswer()
    {
        if (!ActiveUser::getUser()->is_admin) {
            throw new HttpForbiddenException();
        }

        $id = (int)($_GET['id'] ?? null);

        $answerItem = AnswerItem::fromArray($_POST);

        $errors = [];

        $answer = $this->answerRepository->getAnswerById($id);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                $this->quizService->editAnswer($answerItem, $answer);
                return $this->redirect('/admin/view-question?id=' . $answer->question_id);
            } catch (AdminValidationException $exception) {
                $errors = $exception->errorMessage;
            }
        }

        return $this->view('admin/edit/answer', ['answer' => $answer, 'answerItem' => $answerItem, 'errors' => $errors]);
    }
}
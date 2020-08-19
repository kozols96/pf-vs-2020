<?php

namespace Project\Controllers;

use Project\Components\ActiveUser;
use Project\Components\Controller;
use Project\Components\Session;
use Project\Exceptions\AdminValidationException;
use Project\Exceptions\Http\HttpForbiddenException;
use Project\Models\UserModel;
use Project\Repositories\QuizRepository;
use Project\Repositories\UserRepository;
use Project\Services\UserService;

class AdminController extends Controller
{

    private UserRepository $userRepository;
    private QuizRepository  $quizRepository;
    private UserService $userService;

    /**
     * AdminController constructor.
     * @param UserRepository|null $userRepository
     * @param QuizRepository|null $quizRepository
     * @param UserService|null $userService
     */
    public function __construct(
        UserRepository $userRepository = null,
        QuizRepository $quizRepository = null,
        UserService $userService = null
    ) {
        $this->userRepository = $userRepository ?? new UserRepository();
        $this->quizRepository = $quizRepository ?? new QuizRepository();
        $this->userService = $userService ?? new UserService();
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
}
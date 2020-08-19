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
    /**
     * @var UserRepository
     */
    private UserRepository $userRepository;
    private QuizRepository  $quizRepository;
    private UserService $userService;

    public function __construct(
        UserRepository $userRepository = null,
        QuizRepository $quizRepository = null,
        UserService $userService = null
    ) {
        $this->userRepository = $userRepository ?? new UserRepository();
        $this->quizRepository = $quizRepository ?? new QuizRepository();
        $this->userService = $userService ?? new UserService();
    }

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

        if (!$id) {

            Session::getInstance()->setErrorMessage("User ID missing");

            return $this->redirect('/admin');
        }

        $user = $this->userService->getUser($id);

        if (!$user) {

            Session::getInstance()->setErrorMessage("User with ID '{$id}' not found");

            return $this->redirect('/admin');
        }

        return $this->view('admin/view-user', ['user' => $user]);
    }

    public function toggleUserAdmin(): ?string
    {
        if (!ActiveUser::getUser()->is_admin) {
            throw new HttpForbiddenException();
        }
        $id = (int)($_POST['id'] ?? null);
        // TODO: Pārcelt visu no [start] līdz [end] uz servisu.
        // TODO: Visam starp start un end vajadzētu būt try catch blokā
        // TODO: Repozitoriju loģiku (kur ir vaicājums lietotāja atrašanai vai izmaiņas lietotāja modelim) pārcelt uz UserRepository::getUserById, UserRepository::saveModel un izsaukt caur servisu
        // TODO: Ja ir kāds errors (piem. userId === id), metam AdminException ar ziņu iekšā
        // TODO: Tad kļūdas ziņojumu iestatam sesijā caur kontrolieri
        // TODO: Citādāk (ja viss ok), izvadam success message arī caur sesiju un taisam redirect atpakaļ
        // TODO: [start]
        if ($this->userService->isSelectedUserActiveUserForToggle($id)) {

            return $this->redirect($_SERVER['HTTP_REFERER']);
        }

        /** @var UserModel $user */
        $user = $this->userService->getUser($id);

        if (!$user) {
            Session::getInstance()->setErrorMessage("User not found");
        } else {
            $user->is_admin = !$user->is_admin;
            $user->save();
            Session::getInstance()->setSuccessMessage("Admin status successfully toggled");
        }

        // TODO: [end]
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

        if ($this->userService->isSelectedUserActiveUserForDelete($id)) {

            return $this->redirect($_SERVER['HTTP_REFERER']);
        }

        $user = $this->userService->getUser($id);

        if (!$user) {
            Session::getInstance()->setErrorMessage("User not found");
        } else {
            $this->userService->deleteUser($id);
            Session::getInstance()->setSuccessMessage("User successfully deleted");
        }

        // TODO: [end]
        return $this->redirect('/admin');
    }
}
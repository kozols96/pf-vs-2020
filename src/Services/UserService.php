<?php
declare(strict_types=1);

namespace Project\Services;

use Project\Components\ActiveUser;
use Project\Components\Session;
use Project\Exceptions\AdminValidationException;
use Project\Exceptions\UserLoginException;
use Project\Exceptions\UserRegistrationValidationException;
use Project\Models\UserModel;
use Project\Repositories\UserRepository;
use Project\Structures\UserLoginItem;
use Project\Structures\UserRegisterItem;

class UserService
{

    private UserRepository $userRepository;

    private Session $session;

    /**
     * UserService constructor.
     * @param UserRepository|null $userRepository
     * @param Session|null $session
     */
    public function __construct(UserRepository $userRepository = null, Session $session = null)
    {
        $this->userRepository = $userRepository ?? new UserRepository();
        $this->session = $session ?? Session::getInstance();
    }

    /**
     * @param UserRegisterItem $item
     * @return UserModel
     * @throws UserRegistrationValidationException
     */
    public function signUp(UserRegisterItem $item): UserModel
    {

        $this->validateRegisterItemOrFail($item);

        $user = new UserModel();
        $user->email = $item->email;
        $user->password = password_hash($item->password, PASSWORD_DEFAULT);
        $user->name = $item->name;

        $user = $this->userRepository->saveModel($user);

        $this->session->regenerate();
        $this->session->set(Session::KEY_USER_ID, (int)$user->id);

        return $user;
    }

    /**
     * @param UserRegisterItem $item
     * @throws UserRegistrationValidationException
     */
    private function validateRegisterItemOrFail(UserRegisterItem $item): void
    {

        $errors = [];

        if (!filter_var($item->email, FILTER_VALIDATE_EMAIL)) {

            $errors[] = 'Please enter a valid email';

        } elseif ($this->userRepository->checkIsEmailRegistered($item->email)) {

            $errors[] = 'User with this email is already registered!';

        }

        if (!$item->password) {

            $errors[] = 'Please enter the password';

        } elseif (mb_strlen($item->password) < 6 || strlen($item->password) > 72) {

            $errors[] = 'Password must be in a reasonable length!!!';

        }

        if (!$item->name) {

            $errors[] = 'Please enter your name';

        }

        if ($errors) {

            $exception = new UserRegistrationValidationException();
            $exception->errorMessages = $errors;

            throw $exception;
        }
    }

    /**
     * @param int $id
     * @return bool
     */
    public function isSelectedUserActiveUserForToggle(int $id)
    {

        try {
            $this->validateSelectedUserForToggle($id);
        } catch (AdminValidationException $exception) {
            Session::getInstance()->setErrorMessage($exception->getMessage());
        }
        return ActiveUser::getUserId() === $id;
    }

    /**
     * @param int $id
     * @return bool
     */
    public function isSelectedUserActiveUserForDelete(int $id)
    {

        try {
            $this->validateSelectedUserForDelete($id);
        } catch (AdminValidationException $exception) {
            Session::getInstance()->setErrorMessage($exception->getMessage());
        }
        return ActiveUser::getUserId() === $id;
    }

    /**
     * @param int $id
     * @return bool
     * @throws AdminValidationException
     */
    public function validateSelectedUserForToggle(int $id)
    {

        $isSelectedUserActiveUser = ActiveUser::getUserId() === $id;

        if ($isSelectedUserActiveUser === true) {

            throw new AdminValidationException("You can't toggle yourself");
        }

        return true;

    }

    /**
     * @param int $id
     * @return bool
     * @throws AdminValidationException
     */
    public function validateSelectedUserForDelete(int $id)
    {

        $isSelectedUserActiveUser = ActiveUser::getUserId() === $id;

        if ($isSelectedUserActiveUser === true) {

            throw new AdminValidationException("You can't delete yourself");
        }

        return true;

    }


    /**
     * @param UserLoginItem $loginItem
     * @return UserModel|null
     * @throws UserLoginException
     */
    public function signIn(UserLoginItem $loginItem): ?UserModel
    {
        // TODO implement

        if (!$loginItem->email || !$loginItem->password) {
            throw new UserLoginException();
        }

        $user = $this->userRepository->getUserByEmail($loginItem->email);

        if (!$user) {

            throw new UserLoginException();

        }

        if (!password_verify($loginItem->password, $user->password)) {

            throw new UserLoginException();

        }

        $this->session->regenerate();
        $this->session->set(Session::KEY_USER_ID, (int)$user->id);

        return $user;
    }

    public function signOut(): void
    {

        $this->session->destroy();
    }

    /**
     * @param int $id
     * @return UserModel|null
     */
    public function getUser(int $id): ?UserModel
    {

        return $this->userRepository->getUserById($id);
    }

    /**
     * @param int $id
     * @return UserModel
     */
    public function deleteUser(int $id): UserModel
    {
        $user = $this->userRepository->getUserById($id);
        $user->email = null;
        $user->password = null;
        $user->name = 'Former user';

        return $this->userRepository->saveModel($user);
    }
}
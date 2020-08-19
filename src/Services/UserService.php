<?php
declare(strict_types=1);

namespace Project\Services;

use http\Client\Curl\User;
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
     * @param int $activeUserId
     * @return UserModel|null
     * @throws AdminValidationException
     */
    public function viewUser(int $id, int $activeUserId): ?UserModel
    {

        if (!$id) {

            throw new AdminValidationException("User ID missing");
        }


        $user = $this->userRepository->getUserById($id);


        if (!$user) {

            throw new AdminValidationException("User with ID '{$id}' not found");
        }

        return $user;
    }

    /**
     * @param int $id
     * @param int $activeUserId
     * @return UserModel|null
     * @throws AdminValidationException
     */
    public function toggleUserAdmin(int $id, int $activeUserId): ?UserModel
    {

        if ($id === $activeUserId) {

            throw new AdminValidationException("You can't toggle your own admin status!");
        }

        $user = $this->userRepository->getUserById($id);

        if (!$user) {
            throw new AdminValidationException("User not found");
        }

        $user->is_admin = !$user->is_admin;

        return $this->userRepository->saveModel($user);
    }

    /**
     * @param int $id
     * @param int $activeUserId
     * @return UserModel
     * @throws AdminValidationException
     */
    public function deleteUser(int $id, int $activeUserId): ?UserModel
    {
        if ($activeUserId === $id) {
            throw new AdminValidationException("You can't delete yourself");
        }

        $user = $this->userRepository->getUserById($id);

        if (!$user) {
            throw new AdminValidationException("User not found");
        }

        $user->email = null;
        $user->password = null;
        $user->name = 'Former user';

        return $this->userRepository->saveModel($user);
    }
}
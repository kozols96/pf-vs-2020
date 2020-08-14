<?php
declare(strict_types=1);

namespace Project\Services;

use Project\Components\Session;
use Project\Exceptions\UserRegistrationValidationException;
use Project\Models\UserModel;
use Project\Repositories\UserRepository;
use Project\Structures\UserRegisterItem;

class UserService
{

    private UserRepository $userRepository;

    private Session $session;

    /**
     * UserService constructor.
     * @param UserRepository $userRepository
     * @param Session $session
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

    public function signIn(string $email, string $name): ?UserModel
    {
        // TODO implement
        return null;
    }

    public function validateLoginItemOrFail(UserRegisterItem $item): void
    {

        $errors = [];

        if (!$item->email) {

            $errors[] = 'Please enter your email!';

        }

        if (!filter_var($item->email, FILTER_VALIDATE_EMAIL)) {

            $errors[] = 'Please enter a valid email';

        } elseif (!$this->userRepository->checkIsEmailRegistered($item->email)) {

            $errors[] = 'User with this email is already registered!';

        }

    }

    public function signOut(): void
    {
        $this->session->destroy();
    }
}
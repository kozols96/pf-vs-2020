<?php
declare(strict_types=1);

namespace Project\Exceptions;


class UserRegistrationValidationException extends \Exception
{

    public array $errorMessages = [];
}
<?php


namespace Project\Exceptions;


class UserLoginValidationException extends \Exception
{

    public array $errorMessages = [];
}
<?php

namespace Project\Exceptions;


class AdminValidationException extends \Exception
{

    public array $errorMessage = [];
}
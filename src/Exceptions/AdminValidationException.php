<?php

namespace Project\Exceptions;

use Exception;

class AdminValidationException extends Exception
{

    public array $errorMessages = [];
}
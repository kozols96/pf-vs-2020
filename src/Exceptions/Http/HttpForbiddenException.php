<?php

namespace Project\Exceptions\Http;

class HttpForbiddenException extends BaseHttpException
{
    protected $code = 403;
}
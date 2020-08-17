<?php

namespace Project\Exceptions\Http;

class HttpMethodNotAllowedException extends BaseHttpException
{
    protected $code = 405;
}
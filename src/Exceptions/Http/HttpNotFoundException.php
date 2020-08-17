<?php

namespace Project\Exceptions\Http;

class HttpNotFoundException extends BaseHttpException
{
    protected $code = 404;
}
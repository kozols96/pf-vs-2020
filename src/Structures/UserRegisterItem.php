<?php


namespace Project\Structures;


use Project\Traits\FromArrayTrait;


class UserRegisterItem
{

    use FromArrayTrait;

    public ?string $email = null;
    public ?string $password = null;
    public ?string $name = null;
}
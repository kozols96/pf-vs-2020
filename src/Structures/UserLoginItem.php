<?php


namespace Project\Structures;


use Project\Traits\FromArrayTrait;

class UserLoginItem
{

    use FromArrayTrait;

    public ?string $email = null;
    public ?string $password = null;


}
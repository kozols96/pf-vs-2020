<?php


namespace Project\Structures;


use Project\Traits\FromArrayTrait;

class QuizItem
{

    use FromArrayTrait;

    public ?string $name = null;
}
<?php


namespace Project\Structures;


use Project\Traits\FromArrayTrait;

class QuizAddItem
{

    use FromArrayTrait;

    public ?string $name = null;
}
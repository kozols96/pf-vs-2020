<?php


namespace Project\Structures;


use Project\Traits\FromArrayTrait;

class QuestionItem
{

    use FromArrayTrait;

    public ?string $title = null;
}
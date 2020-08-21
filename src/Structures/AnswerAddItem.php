<?php


namespace Project\Structures;


use Project\Traits\FromArrayTrait;

class AnswerAddItem
{

    use FromArrayTrait;

    public ?string $title = null;
}
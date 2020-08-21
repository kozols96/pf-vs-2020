<?php


namespace Project\Structures;


use Project\Traits\FromArrayTrait;

class QuestionAddItem
{

    use FromArrayTrait;

    public ?string $title = null;
}
<?php


namespace Project\Structures;


use Project\Traits\FromArrayTrait;

class AnswerItem
{

    use FromArrayTrait;

    public ?string $title = null;
    public ?bool $is_correct = null;
}
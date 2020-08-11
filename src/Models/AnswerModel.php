<?php


namespace Project\Models;


class AnswerModel
{
    public int $id;

    public int $questionId;

    public string $title;

    public bool $isCorrect;
}
<?php


use Phinx\Seed\AbstractSeed;

class QuizSeeder extends AbstractSeed
{
    private const TABLE_QUIZZES = 'quizzes';
    private const QUIZ_DATA = [
        [
            'name' => 'First quiz',
        ],
    ];

    private const TABLE_QUESTIONS = 'questions';
    private const QUESTION_DATA = [
        [
            'quiz_id' => 1,
            'title' => 'Yes or no?',
        ],
        [
            'quiz_id' => 1,
            'title' => 'No or yes?',
        ],
    ];

    private const TABLE_ANSWERS = 'answers';
    private const ANSWER_DATA = [
        [
            'question_id' => 1,
            'title' => 'Yes',
            'is_correct' => true,
        ],
        [
            'question_id' => 1,
            'title' => 'No',
            'is_correct' => false,
        ],
        [
            'question_id' => 2,
            'title' => 'Yes',
            'is_correct' => false,
        ],
        [
            'question_id' => 2,
            'title' => 'No',
            'is_correct' => true,
        ],
    ];

    public function run(): void
    {
        $this->seedData(self::TABLE_QUIZZES, self::QUIZ_DATA);
        $this->seedData(self::TABLE_QUESTIONS, self::QUESTION_DATA);
        $this->seedData(self::TABLE_ANSWERS, self::ANSWER_DATA);
    }

    private function seedData(string $tableName, array $data): void
    {
        $table = $this->table($tableName);
        foreach ($data as $datum) {
            $table->insert($datum)->save();
        }
    }
}

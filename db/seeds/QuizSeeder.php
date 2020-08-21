<?php

use Phinx\Seed\AbstractSeed;

class QuizSeeder extends AbstractSeed
{
    private const TABLE_QUIZZES = 'quizzes';
    private const TABLE_QUESTIONS = 'questions';
    private const TABLE_ANSWERS = 'answers';

    /**
     * Consists of array of arrays [quiz[], quiz[]...]
     *
     * In each quiz array there should be a name and question array – quiz[name, questions[]]
     *
     * Inside the question array there are arrays of question data – [question[], question[]...]
     * And in each question data array there is title and answer array – question[title, answers[]]
     *
     * Inside the answer array there are arrays of answer data – [answer[], answer[]...]
     * And finally in each answer data array there is title and is_correct data – answer[title, is_correct]
     */
    private const QUIZ_DATA = [
        [
            'name' => 'Yes or no',
            'questions' => [
                [
                    'title' => 'Yes or no?',
                    'answers' => [
                        [
                            'title' => 'Yes',
                            'is_correct' => true,
                        ],
                        [
                            'title' => 'No',
                            'is_correct' => false,
                        ],
                    ],
                ],
                [
                    'title' => 'No or yes?',
                    'answers' => [
                        [
                            'title' => 'Yes',
                            'is_correct' => false,
                        ],
                        [
                            'title' => 'No',
                            'is_correct' => true,
                        ],
                    ],
                ],
            ],
        ],
        [
            'name' => 'Quick maths with Big Shaq',
            'questions' => [
                [
                    'title' => '2 + 2 is',
                    'answers' => [
                        [
                            'title' => '4',
                            'is_correct' => true,
                        ],
                        [
                            'title' => '20',
                            'is_correct' => false,
                        ],
                        [
                            'title' => '999',
                            'is_correct' => false,
                        ],
                        [
                            'title' => '-infinity',
                            'is_correct' => false,
                        ],
                    ],
                ],
                [
                    'title' => '4 - 1 is',
                    'answers' => [
                        [
                            'title' => 'Hot',
                            'is_correct' => false,
                        ],
                        [
                            'title' => '3',
                            'is_correct' => true,
                        ],
                        [
                            'title' => '41',
                            'is_correct' => false,
                        ],
                        [
                            'title' => '-14',
                            'is_correct' => false,
                        ],
                    ],
                ],
                [
                    'title' => 'The ting goes skrrrahh',
                    'answers' => [
                        [
                            'title' => 'pap, pap, ka-ka-ka',
                            'is_correct' => true,
                        ],
                        [
                            'title' => 'SKJA',
                            'is_correct' => false,
                        ],
                        [
                            'title' => "Man's not hot",
                            'is_correct' => false,
                        ],
                        [
                            'title' => "????????",
                            'is_correct' => false,
                        ],
                    ],
                ],
            ],
        ],
    ];


    public function run(): void
    {
        foreach (self::QUIZ_DATA as $quizDatum) {
            $this->seedQuiz($quizDatum);
        }
    }

    /**
     * @param array $quizDatum
     * @see QuizSeeder::QUIZ_DATA Uses the array structure from quiz data
     */
    private function seedQuiz(array $quizDatum): void
    {
        $quizName = $quizDatum['name'];
        $this->table(self::TABLE_QUIZZES)->insert(['name' => $quizName])->save();

        $quizId = $this->getAdapter()->getConnection()->lastInsertId();

        $questions = $quizDatum['questions'];
        foreach ($questions as $question) {
            $questionTitle = $question['title'];

            $this->table(self::TABLE_QUESTIONS)->insert(
                ['quiz_id' => $quizId, 'title' => $questionTitle]
            )->save();

            $questionId = $this->getAdapter()->getConnection()->lastInsertId();

            $questionAnswers = $question['answers'];
            foreach ($questionAnswers as $questionAnswer) {
                $answerTitle = $questionAnswer['title'];
                $answerIsCorrect = $questionAnswer['is_correct'];

                $this->table(self::TABLE_ANSWERS)->insert(
                    ['question_id' => $questionId, 'title' => $answerTitle, 'is_correct' => $answerIsCorrect]
                )->save();
            }
        }
    }
}
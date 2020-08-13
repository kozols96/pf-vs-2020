<?php
declare(strict_types=1);

use Phinx\Db\Table\Column;
use Phinx\Migration\AbstractMigration;

final class CreateTableUserQuizAttemptAnswers extends AbstractMigration
{
    private const TABLE_NAME = 'user_quiz_attempt_answers';

    public function up(): void
    {
        if ($this->hasTable(self::TABLE_NAME)) {
            return;
        }

        $this->table(self::TABLE_NAME, ['id' => false, 'primary_key' => 'id'])
            ->addColumn('id', Column::INTEGER, ['identity' => true, 'signed' => false])
            ->addColumn('attempt_id', Column::INTEGER, ['signed' => false])
            ->addColumn('question_id', Column::INTEGER, ['signed' => false])
            ->addColumn('answer_id', Column::INTEGER, ['signed' => false])
            ->addForeignKey('attempt_id', 'user_quiz_attempts', 'id')
            ->addForeignKey('question_id', 'questions', 'id')
            ->addForeignKey('answer_id', 'answers', 'id')
            ->addIndex(['attempt_id', 'question_id'], ['unique' => true, 'name' => 'unique_attempt_id_question_id'])
            ->create();
    }

    public function down(): void
    {
        if (!$this->hasTable(self::TABLE_NAME)) {
            return;
        }

        $this->table(self::TABLE_NAME)->drop()->save();
    }
}

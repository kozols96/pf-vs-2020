<?php
declare(strict_types=1);

use Phinx\Db\Table\Column;
use Phinx\Migration\AbstractMigration;

final class CreateTableUserQuizAttempts extends AbstractMigration
{

    private const TABLE_NAME = 'user_quiz_attempts';

    public function up(): void
    {
        if ($this->hasTable(self::TABLE_NAME)) {
            return;
        }

        $this->table(self::TABLE_NAME, ['id' => false, 'primary_key' => 'id'])
            ->addColumn('id', Column::INTEGER, ['identity' => true, 'signed' => false])
            ->addColumn('user_id',Column::INTEGER, ['signed' => false])
            ->addColumn('quiz_id',Column::INTEGER, ['signed' => false])
            ->addColumn('started_at',Column::TIMESTAMP, ['update' => ''])
            ->addColumn('finished_at',Column::TIMESTAMP, ['default' => null, 'null' => true, 'update' => ''])
            ->addForeignKey('user_id', 'users', 'id')
            ->addForeignKey('quiz_id','quizzes', 'id')
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

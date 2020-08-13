<?php
declare(strict_types=1);

use Phinx\Db\Table\Column;
use Phinx\Migration\AbstractMigration;

final class CreateTableQuestions extends AbstractMigration
{
    private const TABLE_NAME = 'questions';

    public function up(): void
    {
        if ($this->hasTable(self::TABLE_NAME)) {
            return;
        }

        $this->table(self::TABLE_NAME, ['id' => false, 'primary_key' => 'id'])
            ->addColumn('id', Column::INTEGER, ['identity' => true, 'signed' => false])
            ->addColumn('quiz_id',Column::INTEGER, ['signed' => false])
            ->addColumn('title', Column::STRING, ['limit' => 255])
            ->addForeignKey('quiz_id', 'quizzes', 'id')
            ->create();

    }

    public function down(): void
    {
        if ($this->hasTable(self::TABLE_NAME)) {
            return;
        }

        $this->table(self::TABLE_NAME)->drop()->save();
    }
}

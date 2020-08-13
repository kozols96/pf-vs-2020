<?php
declare(strict_types=1);

use Phinx\Db\Table\Column;
use Phinx\Migration\AbstractMigration;

final class CreateTableAnswers extends AbstractMigration
{
    private const TABLE_NAME = 'answers';

    public function up(): void
    {
        if ($this->hasTable(self::TABLE_NAME)) {
            return;
        }

        $this->table(self::TABLE_NAME, ['id' => false, 'primary_key' => 'id'])
            ->addColumn('id', Column::INTEGER, ['identity' => true, 'signed' => false])
            ->addColumn('question_id',Column::INTEGER, ['signed' => false])
            ->addColumn('title', Column::TEXT)
            ->addColumn('is_correct',Column::BOOLEAN)
            ->addForeignKey('question_id', 'questions', 'id')
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

<?php
declare(strict_types=1);

use Phinx\Db\Table\Column;
use Phinx\Migration\AbstractMigration;

final class CreateTableQuizzes extends AbstractMigration
{

    private const TABLE_NAME = 'quizzes';

    public function up(): void
    {
        if ($this->hasTable(self::TABLE_NAME)) {
            return;
        }

        $this->table(self::TABLE_NAME, ['id' => false, 'primary_key' => 'id'])
            ->addColumn('id', Column::INTEGER, ['identity' => true, 'signed' => false])
            ->addColumn('name', Column::STRING, ['limit' => 64])
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

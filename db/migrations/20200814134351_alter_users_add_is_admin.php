<?php
declare(strict_types=1);

use Phinx\Db\Table\Column;
use Phinx\Migration\AbstractMigration;

final class AlterUsersAddIsAdmin extends AbstractMigration
{

    private const TABLE_NAME = 'users';

    public function up(): void
    {
        $this->table(self::TABLE_NAME)
            ->addColumn(
                'is_admin',
                Column::BOOLEAN,
                ['after' => 'name', 'default' => false]
            )->save();
    }

    public function down(): void
    {
        $this->table(self::TABLE_NAME)->removeColumn('is_admin')->save();
    }
}

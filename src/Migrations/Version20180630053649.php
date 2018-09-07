<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\DBAL\Types\Type;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20180630053649 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        $table = $schema->createTable('user');
        $table->addColumn('id','integer')
            ->setAutoincrement(true);
        $table->addColumn('username',Type::STRING)
            ->setLength(255)
            ->setNotnull(true);
        $table->addColumn('password',Type::STRING)
            ->setLength(255)
            ->setNotnull(true);
        $table->addColumn('type',Type::SMALLINT)->setLength(4);
        $table->addColumn('avatar',Type::STRING)
            ->setLength(255)
            ->setNotnull(false);
        $table->addColumn('gender',Type::SMALLINT)
            ->setLength(4)
            ->setNotnull(true);
        $table->addColumn('roles',Type::SIMPLE_ARRAY);
        $table->addColumn('is_active',Type::BOOLEAN)
            ->setNotnull(true)->setDefault(1);
        $table->addColumn('created_at',Type::DATETIME)
            ->setNotnull(true);

        $table->setPrimaryKey(['id']);
        $table->addUniqueIndex(['username']);

    }

    public function down(Schema $schema) : void
    {
        $schema->dropTable('user');
    }
}

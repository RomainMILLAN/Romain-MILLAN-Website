<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20260419114342 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add order_number column to application table';
    }

    public function up(Schema $schema): void
    {
        $this->addSql(<<<'SQL'
            ALTER TABLE application ADD order_number INTEGER DEFAULT 0 NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            UPDATE application SET order_number = id
        SQL);
    }

    public function down(Schema $schema): void
    {
        $this->addSql(<<<'SQL'
            ALTER TABLE application DROP order_number
        SQL);
    }
}

<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20260417165727 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Drop push_notification table (notification system removed)';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('DROP INDEX IF EXISTS unique_push_notification');
        $this->addSql('DROP TABLE IF EXISTS push_notification');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('CREATE TABLE push_notification (id SERIAL PRIMARY KEY, endpoint VARCHAR(255) NOT NULL, p256dh VARCHAR(255) NOT NULL, auth VARCHAR(255) NOT NULL)');
        $this->addSql('CREATE UNIQUE INDEX unique_push_notification ON push_notification (endpoint, p256dh, auth)');
    }
}

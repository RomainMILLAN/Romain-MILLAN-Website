<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20251102140439 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create push_notification table';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE push_notification (id SERIAL PRIMARY KEY, endpoint VARCHAR(255) NOT NULL, p256dh VARCHAR(255) NOT NULL, auth VARCHAR(255) NOT NULL)');
        $this->addSql('CREATE UNIQUE INDEX unique_push_notification ON push_notification (endpoint, p256dh, auth)');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE push_notification');
    }
}

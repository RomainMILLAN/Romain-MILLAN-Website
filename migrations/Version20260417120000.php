<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20260417120000 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create infrastructure_service table and add relation to application';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE infrastructure_service (id SERIAL PRIMARY KEY, name VARCHAR(255) NOT NULL, ip_address VARCHAR(45) NOT NULL)');
        $this->addSql('ALTER TABLE application ADD infrastructure_service_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE application ADD CONSTRAINT FK_A45BDDC1B8E15710 FOREIGN KEY (infrastructure_service_id) REFERENCES infrastructure_service (id) ON DELETE SET NULL NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_A45BDDC1B8E15710 ON application (infrastructure_service_id)');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE application DROP CONSTRAINT FK_A45BDDC1B8E15710');
        $this->addSql('DROP INDEX IDX_A45BDDC1B8E15710');
        $this->addSql('ALTER TABLE application DROP infrastructure_service_id');
        $this->addSql('DROP TABLE infrastructure_service');
    }
}

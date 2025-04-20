<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250419155702 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE application (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, category_id INTEGER NOT NULL, name VARCHAR(255) NOT NULL, description CLOB DEFAULT NULL, url CLOB NOT NULL, icon VARCHAR(255) NOT NULL, has_interface BOOLEAN NOT NULL, CONSTRAINT FK_A45BDDC112469DE2 FOREIGN KEY (category_id) REFERENCES application_category (id) NOT DEFERRABLE INITIALLY IMMEDIATE)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_A45BDDC112469DE2 ON application (category_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE application_category (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) NOT NULL, in_accordion BOOLEAN NOT NULL)
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            DROP TABLE application
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE application_category
        SQL);
    }
}

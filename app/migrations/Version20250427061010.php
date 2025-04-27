<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250427061010 extends AbstractMigration
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
            CREATE TABLE application_application_type (application_id INTEGER NOT NULL, application_type_id INTEGER NOT NULL, PRIMARY KEY(application_id, application_type_id), CONSTRAINT FK_28A7126E3E030ACD FOREIGN KEY (application_id) REFERENCES application (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_28A7126E2EF289A0 FOREIGN KEY (application_type_id) REFERENCES application_type (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_28A7126E3E030ACD ON application_application_type (application_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_28A7126E2EF289A0 ON application_application_type (application_type_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE application_category (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) NOT NULL, in_accordion BOOLEAN NOT NULL, order_number INTEGER NOT NULL)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE application_type (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) NOT NULL, color VARCHAR(255) NOT NULL)
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            DROP TABLE application
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE application_application_type
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE application_category
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE application_type
        SQL);
    }
}

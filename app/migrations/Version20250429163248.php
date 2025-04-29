<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250429163248 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE application_application_category (application_id INTEGER NOT NULL, application_category_id INTEGER NOT NULL, PRIMARY KEY(application_id, application_category_id), CONSTRAINT FK_599893203E030ACD FOREIGN KEY (application_id) REFERENCES application (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_59989320BB8DB080 FOREIGN KEY (application_category_id) REFERENCES application_category (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_599893203E030ACD ON application_application_category (application_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_59989320BB8DB080 ON application_application_category (application_category_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TEMPORARY TABLE __temp__application AS SELECT id, name, description, url, icon, has_interface FROM application
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE application
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE application (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) NOT NULL, description CLOB DEFAULT NULL, url CLOB NOT NULL, icon VARCHAR(255) NOT NULL, has_interface BOOLEAN NOT NULL)
        SQL);
        $this->addSql(<<<'SQL'
            INSERT INTO application (id, name, description, url, icon, has_interface) SELECT id, name, description, url, icon, has_interface FROM __temp__application
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE __temp__application
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            DROP TABLE application_application_category
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TEMPORARY TABLE __temp__application AS SELECT id, name, description, url, icon, has_interface FROM application
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE application
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE application (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, category_id INTEGER NOT NULL, name VARCHAR(255) NOT NULL, description CLOB DEFAULT NULL, url CLOB NOT NULL, icon VARCHAR(255) NOT NULL, has_interface BOOLEAN NOT NULL, CONSTRAINT FK_A45BDDC112469DE2 FOREIGN KEY (category_id) REFERENCES application_category (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE)
        SQL);
        $this->addSql(<<<'SQL'
            INSERT INTO application (id, name, description, url, icon, has_interface) SELECT id, name, description, url, icon, has_interface FROM __temp__application
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE __temp__application
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_A45BDDC112469DE2 ON application (category_id)
        SQL);
    }
}

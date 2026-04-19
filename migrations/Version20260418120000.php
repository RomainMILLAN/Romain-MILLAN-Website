<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20260418120000 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create doc_page, doc_tag and doc_page_doc_tag tables';
    }

    public function up(Schema $schema): void
    {
        $this->addSql(<<<'SQL'
            CREATE TABLE doc_page (id SERIAL PRIMARY KEY, title VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, content TEXT DEFAULT '' NOT NULL, created_at TIMESTAMP(0) WITH TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITH TIME ZONE NOT NULL)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE UNIQUE INDEX UNIQ_DOC_PAGE_SLUG ON doc_page (slug)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE doc_tag (id SERIAL PRIMARY KEY, name VARCHAR(255) NOT NULL, color VARCHAR(7) NOT NULL)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE UNIQUE INDEX UNIQ_DOC_TAG_NAME ON doc_tag (name)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE doc_page_doc_tag (doc_page_id INTEGER NOT NULL, doc_tag_id INTEGER NOT NULL, PRIMARY KEY(doc_page_id, doc_tag_id), CONSTRAINT FK_DOC_PAGE_DOC_TAG_PAGE FOREIGN KEY (doc_page_id) REFERENCES doc_page (id) ON DELETE CASCADE, CONSTRAINT FK_DOC_PAGE_DOC_TAG_TAG FOREIGN KEY (doc_tag_id) REFERENCES doc_tag (id) ON DELETE CASCADE)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_DOC_PAGE_DOC_TAG_PAGE ON doc_page_doc_tag (doc_page_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_DOC_PAGE_DOC_TAG_TAG ON doc_page_doc_tag (doc_tag_id)
        SQL);
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE doc_page_doc_tag');
        $this->addSql('DROP TABLE doc_page');
        $this->addSql('DROP TABLE doc_tag');
    }
}

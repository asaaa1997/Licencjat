<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210721203707 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE sentences ADD author_id INT UNSIGNED DEFAULT NULL');
        $this->addSql('ALTER TABLE sentences ADD CONSTRAINT FK_ED2A8F1EF675F31B FOREIGN KEY (author_id) REFERENCES users (id)');
        $this->addSql('CREATE INDEX IDX_ED2A8F1EF675F31B ON sentences (author_id)');
        $this->addSql('ALTER TABLE words ADD author_id INT UNSIGNED DEFAULT NULL');
        $this->addSql('ALTER TABLE words ADD CONSTRAINT FK_717D1E8CF675F31B FOREIGN KEY (author_id) REFERENCES users (id)');
        $this->addSql('CREATE INDEX IDX_717D1E8CF675F31B ON words (author_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE sentences DROP FOREIGN KEY FK_ED2A8F1EF675F31B');
        $this->addSql('DROP INDEX IDX_ED2A8F1EF675F31B ON sentences');
        $this->addSql('ALTER TABLE sentences DROP author_id');
        $this->addSql('ALTER TABLE words DROP FOREIGN KEY FK_717D1E8CF675F31B');
        $this->addSql('DROP INDEX IDX_717D1E8CF675F31B ON words');
        $this->addSql('ALTER TABLE words DROP author_id');
    }
}

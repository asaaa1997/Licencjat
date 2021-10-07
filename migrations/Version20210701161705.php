<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210701161705 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE sentences ADD language_id INT NOT NULL');
        $this->addSql('ALTER TABLE sentences ADD CONSTRAINT FK_ED2A8F1E82F1BAF4 FOREIGN KEY (language_id) REFERENCES languages (id)');
        $this->addSql('CREATE INDEX IDX_ED2A8F1E82F1BAF4 ON sentences (language_id)');
        $this->addSql('ALTER TABLE words ADD language_id INT NOT NULL');
        $this->addSql('ALTER TABLE words ADD CONSTRAINT FK_717D1E8C82F1BAF4 FOREIGN KEY (language_id) REFERENCES languages (id)');
        $this->addSql('CREATE INDEX IDX_717D1E8C82F1BAF4 ON words (language_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE sentences DROP FOREIGN KEY FK_ED2A8F1E82F1BAF4');
        $this->addSql('DROP INDEX IDX_ED2A8F1E82F1BAF4 ON sentences');
        $this->addSql('ALTER TABLE sentences DROP language_id');
        $this->addSql('ALTER TABLE words DROP FOREIGN KEY FK_717D1E8C82F1BAF4');
        $this->addSql('DROP INDEX IDX_717D1E8C82F1BAF4 ON words');
        $this->addSql('ALTER TABLE words DROP language_id');
    }
}

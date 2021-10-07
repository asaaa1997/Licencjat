<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210705160558 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE words_translations (word_id INT NOT NULL, translation_id INT NOT NULL, INDEX IDX_6F28EB72E357438D (word_id), INDEX IDX_6F28EB729CAA2B25 (translation_id), PRIMARY KEY(word_id, translation_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE words_translations ADD CONSTRAINT FK_6F28EB72E357438D FOREIGN KEY (word_id) REFERENCES words (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE words_translations ADD CONSTRAINT FK_6F28EB729CAA2B25 FOREIGN KEY (translation_id) REFERENCES translations (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE words_translations');
    }
}

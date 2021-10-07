<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210608001950 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE words ADD category_id INT NOT NULL');
        $this->addSql('ALTER TABLE words ADD CONSTRAINT FK_717D1E8C12469DE2 FOREIGN KEY (category_id) REFERENCES categories (id)');
        $this->addSql('CREATE INDEX IDX_717D1E8C12469DE2 ON words (category_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE words DROP FOREIGN KEY FK_717D1E8C12469DE2');
        $this->addSql('DROP INDEX IDX_717D1E8C12469DE2 ON words');
        $this->addSql('ALTER TABLE words DROP category_id');
    }
}

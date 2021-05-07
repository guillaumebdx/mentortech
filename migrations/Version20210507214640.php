<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210507214640 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE part ADD lesson_id INT NOT NULL');
        $this->addSql('ALTER TABLE part ADD CONSTRAINT FK_490F70C6CDF80196 FOREIGN KEY (lesson_id) REFERENCES lesson (id)');
        $this->addSql('CREATE INDEX IDX_490F70C6CDF80196 ON part (lesson_id)');
        $this->addSql('ALTER TABLE user ADD github_name VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE part DROP FOREIGN KEY FK_490F70C6CDF80196');
        $this->addSql('DROP INDEX IDX_490F70C6CDF80196 ON part');
        $this->addSql('ALTER TABLE part DROP lesson_id');
        $this->addSql('ALTER TABLE user DROP github_name');
    }
}

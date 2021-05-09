<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210508232005 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE lesson ADD content_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE lesson ADD CONSTRAINT FK_F87474F384A0A3ED FOREIGN KEY (content_id) REFERENCES content (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_F87474F384A0A3ED ON lesson (content_id)');
        $this->addSql('ALTER TABLE part DROP FOREIGN KEY FK_490F70C6CDF80196');
        $this->addSql('DROP INDEX IDX_490F70C6CDF80196 ON part');
        $this->addSql('ALTER TABLE part DROP lesson_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE lesson DROP FOREIGN KEY FK_F87474F384A0A3ED');
        $this->addSql('DROP INDEX UNIQ_F87474F384A0A3ED ON lesson');
        $this->addSql('ALTER TABLE lesson DROP content_id');
        $this->addSql('ALTER TABLE part ADD lesson_id INT NOT NULL');
        $this->addSql('ALTER TABLE part ADD CONSTRAINT FK_490F70C6CDF80196 FOREIGN KEY (lesson_id) REFERENCES lesson (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_490F70C6CDF80196 ON part (lesson_id)');
    }
}

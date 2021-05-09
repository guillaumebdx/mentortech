<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210509153832 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE screencast DROP FOREIGN KEY FK_E1262F0C84A0A3ED');
        $this->addSql('DROP INDEX IDX_E1262F0C84A0A3ED ON screencast');
        $this->addSql('ALTER TABLE screencast CHANGE content_id part_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE screencast ADD CONSTRAINT FK_E1262F0C4CE34BEC FOREIGN KEY (part_id) REFERENCES part (id)');
        $this->addSql('CREATE INDEX IDX_E1262F0C4CE34BEC ON screencast (part_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE screencast DROP FOREIGN KEY FK_E1262F0C4CE34BEC');
        $this->addSql('DROP INDEX IDX_E1262F0C4CE34BEC ON screencast');
        $this->addSql('ALTER TABLE screencast CHANGE part_id content_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE screencast ADD CONSTRAINT FK_E1262F0C84A0A3ED FOREIGN KEY (content_id) REFERENCES content (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_E1262F0C84A0A3ED ON screencast (content_id)');
    }
}

<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210516212731 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE attribution (id INT AUTO_INCREMENT NOT NULL, program_id INT DEFAULT NULL, user_id INT DEFAULT NULL, end_at DATETIME DEFAULT NULL, INDEX IDX_C751ED493EB8070A (program_id), INDEX IDX_C751ED49A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE content (id INT AUTO_INCREMENT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, introduction LONGTEXT DEFAULT NULL, final_exercise LONGTEXT DEFAULT NULL, final_solution LONGTEXT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE correction (id INT AUTO_INCREMENT NOT NULL, comment LONGTEXT NOT NULL, is_valid TINYINT(1) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE correction_user (correction_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_6C2C6E2F94AE086B (correction_id), INDEX IDX_6C2C6E2FA76ED395 (user_id), PRIMARY KEY(correction_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE lesson (id INT AUTO_INCREMENT NOT NULL, content_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, UNIQUE INDEX UNIQ_F87474F384A0A3ED (content_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE lesson_technology (lesson_id INT NOT NULL, technology_id INT NOT NULL, INDEX IDX_F96A1B9CCDF80196 (lesson_id), INDEX IDX_F96A1B9C4235D463 (technology_id), PRIMARY KEY(lesson_id, technology_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE part (id INT AUTO_INCREMENT NOT NULL, content_id INT DEFAULT NULL, introduction LONGTEXT DEFAULT NULL, description LONGTEXT NOT NULL, exercise LONGTEXT DEFAULT NULL, solution LONGTEXT DEFAULT NULL, title VARCHAR(255) NOT NULL, INDEX IDX_490F70C684A0A3ED (content_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE posted_solution (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, lesson_id INT DEFAULT NULL, correction_id INT DEFAULT NULL, url VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, is_valid TINYINT(1) NOT NULL, mentor_comment LONGTEXT DEFAULT NULL, INDEX IDX_85C1AE30A76ED395 (user_id), INDEX IDX_85C1AE30CDF80196 (lesson_id), INDEX IDX_85C1AE3094AE086B (correction_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE program (id INT AUTO_INCREMENT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, name VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE program_lesson (program_id INT NOT NULL, lesson_id INT NOT NULL, INDEX IDX_AC344AA93EB8070A (program_id), INDEX IDX_AC344AA9CDF80196 (lesson_id), PRIMARY KEY(program_id, lesson_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reset_password_request (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, selector VARCHAR(20) NOT NULL, hashed_token VARCHAR(100) NOT NULL, requested_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', expires_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_7CE748AA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reviewer (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE screencast (id INT AUTO_INCREMENT NOT NULL, part_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_E1262F0C4CE34BEC (part_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE status_lesson (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, lesson_id INT DEFAULT NULL, is_posted TINYINT(1) DEFAULT NULL, is_valid TINYINT(1) DEFAULT NULL, is_open TINYINT(1) NOT NULL, INDEX IDX_453EDCBEA76ED395 (user_id), INDEX IDX_453EDCBECDF80196 (lesson_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE technology (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, identifier VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, credit INT NOT NULL, github_name VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE attribution ADD CONSTRAINT FK_C751ED493EB8070A FOREIGN KEY (program_id) REFERENCES program (id)');
        $this->addSql('ALTER TABLE attribution ADD CONSTRAINT FK_C751ED49A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE correction_user ADD CONSTRAINT FK_6C2C6E2F94AE086B FOREIGN KEY (correction_id) REFERENCES correction (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE correction_user ADD CONSTRAINT FK_6C2C6E2FA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE lesson ADD CONSTRAINT FK_F87474F384A0A3ED FOREIGN KEY (content_id) REFERENCES content (id)');
        $this->addSql('ALTER TABLE lesson_technology ADD CONSTRAINT FK_F96A1B9CCDF80196 FOREIGN KEY (lesson_id) REFERENCES lesson (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE lesson_technology ADD CONSTRAINT FK_F96A1B9C4235D463 FOREIGN KEY (technology_id) REFERENCES technology (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE part ADD CONSTRAINT FK_490F70C684A0A3ED FOREIGN KEY (content_id) REFERENCES content (id)');
        $this->addSql('ALTER TABLE posted_solution ADD CONSTRAINT FK_85C1AE30A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE posted_solution ADD CONSTRAINT FK_85C1AE30CDF80196 FOREIGN KEY (lesson_id) REFERENCES lesson (id)');
        $this->addSql('ALTER TABLE posted_solution ADD CONSTRAINT FK_85C1AE3094AE086B FOREIGN KEY (correction_id) REFERENCES correction (id)');
        $this->addSql('ALTER TABLE program_lesson ADD CONSTRAINT FK_AC344AA93EB8070A FOREIGN KEY (program_id) REFERENCES program (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE program_lesson ADD CONSTRAINT FK_AC344AA9CDF80196 FOREIGN KEY (lesson_id) REFERENCES lesson (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE reset_password_request ADD CONSTRAINT FK_7CE748AA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE screencast ADD CONSTRAINT FK_E1262F0C4CE34BEC FOREIGN KEY (part_id) REFERENCES part (id)');
        $this->addSql('ALTER TABLE status_lesson ADD CONSTRAINT FK_453EDCBEA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE status_lesson ADD CONSTRAINT FK_453EDCBECDF80196 FOREIGN KEY (lesson_id) REFERENCES lesson (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE lesson DROP FOREIGN KEY FK_F87474F384A0A3ED');
        $this->addSql('ALTER TABLE part DROP FOREIGN KEY FK_490F70C684A0A3ED');
        $this->addSql('ALTER TABLE correction_user DROP FOREIGN KEY FK_6C2C6E2F94AE086B');
        $this->addSql('ALTER TABLE posted_solution DROP FOREIGN KEY FK_85C1AE3094AE086B');
        $this->addSql('ALTER TABLE lesson_technology DROP FOREIGN KEY FK_F96A1B9CCDF80196');
        $this->addSql('ALTER TABLE posted_solution DROP FOREIGN KEY FK_85C1AE30CDF80196');
        $this->addSql('ALTER TABLE program_lesson DROP FOREIGN KEY FK_AC344AA9CDF80196');
        $this->addSql('ALTER TABLE status_lesson DROP FOREIGN KEY FK_453EDCBECDF80196');
        $this->addSql('ALTER TABLE screencast DROP FOREIGN KEY FK_E1262F0C4CE34BEC');
        $this->addSql('ALTER TABLE attribution DROP FOREIGN KEY FK_C751ED493EB8070A');
        $this->addSql('ALTER TABLE program_lesson DROP FOREIGN KEY FK_AC344AA93EB8070A');
        $this->addSql('ALTER TABLE lesson_technology DROP FOREIGN KEY FK_F96A1B9C4235D463');
        $this->addSql('ALTER TABLE attribution DROP FOREIGN KEY FK_C751ED49A76ED395');
        $this->addSql('ALTER TABLE correction_user DROP FOREIGN KEY FK_6C2C6E2FA76ED395');
        $this->addSql('ALTER TABLE posted_solution DROP FOREIGN KEY FK_85C1AE30A76ED395');
        $this->addSql('ALTER TABLE reset_password_request DROP FOREIGN KEY FK_7CE748AA76ED395');
        $this->addSql('ALTER TABLE status_lesson DROP FOREIGN KEY FK_453EDCBEA76ED395');
        $this->addSql('DROP TABLE attribution');
        $this->addSql('DROP TABLE content');
        $this->addSql('DROP TABLE correction');
        $this->addSql('DROP TABLE correction_user');
        $this->addSql('DROP TABLE lesson');
        $this->addSql('DROP TABLE lesson_technology');
        $this->addSql('DROP TABLE part');
        $this->addSql('DROP TABLE posted_solution');
        $this->addSql('DROP TABLE program');
        $this->addSql('DROP TABLE program_lesson');
        $this->addSql('DROP TABLE reset_password_request');
        $this->addSql('DROP TABLE reviewer');
        $this->addSql('DROP TABLE screencast');
        $this->addSql('DROP TABLE status_lesson');
        $this->addSql('DROP TABLE technology');
        $this->addSql('DROP TABLE user');
    }
}

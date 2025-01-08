<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250108121753 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE seasons (id INT AUTO_INCREMENT NOT NULL, program_id_id INT NOT NULL, number INT NOT NULL, year INT DEFAULT NULL, numbers_episode INT NOT NULL, description LONGTEXT DEFAULT NULL, INDEX IDX_B4F4301CE12DEDA1 (program_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE seasons ADD CONSTRAINT FK_B4F4301CE12DEDA1 FOREIGN KEY (program_id_id) REFERENCES program (id)');
        $this->addSql('ALTER TABLE program CHANGE poster poster VARCHAR(50) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE seasons DROP FOREIGN KEY FK_B4F4301CE12DEDA1');
        $this->addSql('DROP TABLE seasons');
        $this->addSql('ALTER TABLE program CHANGE poster poster VARCHAR(2000) DEFAULT NULL');
    }
}

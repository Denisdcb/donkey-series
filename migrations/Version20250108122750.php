<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250108122750 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE episodes (id INT AUTO_INCREMENT NOT NULL, program_id_id INT NOT NULL, season_id_id INT NOT NULL, title LONGTEXT NOT NULL, number INT NOT NULL, description LONGTEXT DEFAULT NULL, INDEX IDX_7DD55EDDE12DEDA1 (program_id_id), INDEX IDX_7DD55EDD68756988 (season_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE episodes ADD CONSTRAINT FK_7DD55EDDE12DEDA1 FOREIGN KEY (program_id_id) REFERENCES program (id)');
        $this->addSql('ALTER TABLE episodes ADD CONSTRAINT FK_7DD55EDD68756988 FOREIGN KEY (season_id_id) REFERENCES seasons (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE episodes DROP FOREIGN KEY FK_7DD55EDDE12DEDA1');
        $this->addSql('ALTER TABLE episodes DROP FOREIGN KEY FK_7DD55EDD68756988');
        $this->addSql('DROP TABLE episodes');
    }
}

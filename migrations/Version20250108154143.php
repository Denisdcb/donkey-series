<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250108154143 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE episodes DROP FOREIGN KEY FK_7DD55EDD68756988');
        $this->addSql('ALTER TABLE episodes DROP FOREIGN KEY FK_7DD55EDDE12DEDA1');
        $this->addSql('DROP INDEX IDX_7DD55EDD68756988 ON episodes');
        $this->addSql('DROP INDEX IDX_7DD55EDDE12DEDA1 ON episodes');
        $this->addSql('ALTER TABLE episodes ADD program_id INT NOT NULL, ADD season_id INT NOT NULL, DROP program_id_id, DROP season_id_id');
        $this->addSql('ALTER TABLE episodes ADD CONSTRAINT FK_7DD55EDD3EB8070A FOREIGN KEY (program_id) REFERENCES program (id)');
        $this->addSql('ALTER TABLE episodes ADD CONSTRAINT FK_7DD55EDD4EC001D1 FOREIGN KEY (season_id) REFERENCES seasons (id)');
        $this->addSql('CREATE INDEX IDX_7DD55EDD3EB8070A ON episodes (program_id)');
        $this->addSql('CREATE INDEX IDX_7DD55EDD4EC001D1 ON episodes (season_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE episodes DROP FOREIGN KEY FK_7DD55EDD3EB8070A');
        $this->addSql('ALTER TABLE episodes DROP FOREIGN KEY FK_7DD55EDD4EC001D1');
        $this->addSql('DROP INDEX IDX_7DD55EDD3EB8070A ON episodes');
        $this->addSql('DROP INDEX IDX_7DD55EDD4EC001D1 ON episodes');
        $this->addSql('ALTER TABLE episodes ADD program_id_id INT NOT NULL, ADD season_id_id INT NOT NULL, DROP program_id, DROP season_id');
        $this->addSql('ALTER TABLE episodes ADD CONSTRAINT FK_7DD55EDD68756988 FOREIGN KEY (season_id_id) REFERENCES seasons (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE episodes ADD CONSTRAINT FK_7DD55EDDE12DEDA1 FOREIGN KEY (program_id_id) REFERENCES program (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_7DD55EDD68756988 ON episodes (season_id_id)');
        $this->addSql('CREATE INDEX IDX_7DD55EDDE12DEDA1 ON episodes (program_id_id)');
    }
}

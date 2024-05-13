<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240331224257 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE rdv ADD id_patient_id INT NOT NULL');
        $this->addSql('ALTER TABLE rdv ADD CONSTRAINT FK_10C31F86CE0312AE FOREIGN KEY (id_patient_id) REFERENCES patient (id)');
        $this->addSql('CREATE INDEX IDX_10C31F86CE0312AE ON rdv (id_patient_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE rdv DROP FOREIGN KEY FK_10C31F86CE0312AE');
        $this->addSql('DROP INDEX IDX_10C31F86CE0312AE ON rdv');
        $this->addSql('ALTER TABLE rdv DROP id_patient_id');
    }
}

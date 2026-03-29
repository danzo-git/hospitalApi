<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250122223442 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE doctor ADD date_debut DATETIME DEFAULT NULL, ADD heure_debut_matin DATETIME DEFAULT NULL, ADD heure_debut_apres_midi DATETIME DEFAULT NULL, ADD heure_fin_apres_midi DATETIME DEFAULT NULL, ADD jours_travailles JSON DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE `doctor` DROP date_debut, DROP heure_debut_matin, DROP heure_debut_apres_midi, DROP heure_fin_apres_midi, DROP jours_travailles');
    }
}

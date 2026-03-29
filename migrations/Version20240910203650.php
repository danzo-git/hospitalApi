<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240910203650 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE role_patient (role_id INT NOT NULL, patient_id INT NOT NULL, INDEX IDX_A6177210D60322AC (role_id), INDEX IDX_A61772106B899279 (patient_id), PRIMARY KEY(role_id, patient_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE role_patient ADD CONSTRAINT FK_A6177210D60322AC FOREIGN KEY (role_id) REFERENCES role (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE role_patient ADD CONSTRAINT FK_A61772106B899279 FOREIGN KEY (patient_id) REFERENCES patient (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE patient_role DROP FOREIGN KEY FK_DEF8C7A26B899279');
        $this->addSql('ALTER TABLE patient_role DROP FOREIGN KEY FK_DEF8C7A2D60322AC');
        $this->addSql('DROP TABLE patient_role');
        $this->addSql('ALTER TABLE patient ADD roles JSON NOT NULL');
        $this->addSql('DROP INDEX UNIQ_57698A6A5E237E06 ON role');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE patient_role (patient_id INT NOT NULL, role_id INT NOT NULL, INDEX IDX_DEF8C7A26B899279 (patient_id), INDEX IDX_DEF8C7A2D60322AC (role_id), PRIMARY KEY(patient_id, role_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE patient_role ADD CONSTRAINT FK_DEF8C7A26B899279 FOREIGN KEY (patient_id) REFERENCES patient (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE patient_role ADD CONSTRAINT FK_DEF8C7A2D60322AC FOREIGN KEY (role_id) REFERENCES role (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE role_patient DROP FOREIGN KEY FK_A6177210D60322AC');
        $this->addSql('ALTER TABLE role_patient DROP FOREIGN KEY FK_A61772106B899279');
        $this->addSql('DROP TABLE role_patient');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_57698A6A5E237E06 ON role (name)');
        $this->addSql('ALTER TABLE patient DROP roles');
    }
}

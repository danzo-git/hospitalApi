<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240910223723 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE patient_roles (patient_id INT NOT NULL, role_id INT NOT NULL, INDEX IDX_2308F5086B899279 (patient_id), INDEX IDX_2308F508D60322AC (role_id), PRIMARY KEY(patient_id, role_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE patient_roles ADD CONSTRAINT FK_2308F5086B899279 FOREIGN KEY (patient_id) REFERENCES patient (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE patient_roles ADD CONSTRAINT FK_2308F508D60322AC FOREIGN KEY (role_id) REFERENCES role (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE role_patient DROP FOREIGN KEY FK_A61772106B899279');
        $this->addSql('ALTER TABLE role_patient DROP FOREIGN KEY FK_A6177210D60322AC');
        $this->addSql('DROP TABLE role_patient');
        $this->addSql('ALTER TABLE patient DROP roles');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1ADAD7EBE7927C74 ON patient (email)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_57698A6A5E237E06 ON role (name)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE role_patient (role_id INT NOT NULL, patient_id INT NOT NULL, INDEX IDX_A61772106B899279 (patient_id), INDEX IDX_A6177210D60322AC (role_id), PRIMARY KEY(role_id, patient_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE role_patient ADD CONSTRAINT FK_A61772106B899279 FOREIGN KEY (patient_id) REFERENCES patient (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE role_patient ADD CONSTRAINT FK_A6177210D60322AC FOREIGN KEY (role_id) REFERENCES role (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE patient_roles DROP FOREIGN KEY FK_2308F5086B899279');
        $this->addSql('ALTER TABLE patient_roles DROP FOREIGN KEY FK_2308F508D60322AC');
        $this->addSql('DROP TABLE patient_roles');
        $this->addSql('DROP INDEX UNIQ_1ADAD7EBE7927C74 ON patient');
        $this->addSql('ALTER TABLE patient ADD roles JSON NOT NULL');
        $this->addSql('DROP INDEX UNIQ_57698A6A5E237E06 ON role');
    }
}

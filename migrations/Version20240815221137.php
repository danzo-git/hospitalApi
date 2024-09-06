<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240815221137 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE role (id INT AUTO_INCREMENT NOT NULL, doctor_id INT DEFAULT NULL, patient_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, INDEX IDX_57698A6A87F4FB17 (doctor_id), INDEX IDX_57698A6A6B899279 (patient_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE role ADD CONSTRAINT FK_57698A6A87F4FB17 FOREIGN KEY (doctor_id) REFERENCES `doctor` (id)');
        $this->addSql('ALTER TABLE role ADD CONSTRAINT FK_57698A6A6B899279 FOREIGN KEY (patient_id) REFERENCES `patient` (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE role DROP FOREIGN KEY FK_57698A6A87F4FB17');
        $this->addSql('ALTER TABLE role DROP FOREIGN KEY FK_57698A6A6B899279');
        $this->addSql('DROP TABLE role');
    }
}

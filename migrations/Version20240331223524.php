<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240331223524 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE doctor (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, speciality VARCHAR(255) NOT NULL, grade VARCHAR(255) NOT NULL, year_of_experience INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE hospital (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, position VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE hospital_doctor (hospital_id INT NOT NULL, doctor_id INT NOT NULL, INDEX IDX_C0A1463963DBB69 (hospital_id), INDEX IDX_C0A1463987F4FB17 (doctor_id), PRIMARY KEY(hospital_id, doctor_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE patient (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, first_name VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, number VARCHAR(255) NOT NULL, age INT NOT NULL, allergy VARCHAR(255) DEFAULT NULL, potential_illness VARCHAR(255) DEFAULT NULL, file VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE rdv (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE service (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, status TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE hospital_doctor ADD CONSTRAINT FK_C0A1463963DBB69 FOREIGN KEY (hospital_id) REFERENCES hospital (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE hospital_doctor ADD CONSTRAINT FK_C0A1463987F4FB17 FOREIGN KEY (doctor_id) REFERENCES doctor (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE hospital_doctor DROP FOREIGN KEY FK_C0A1463963DBB69');
        $this->addSql('ALTER TABLE hospital_doctor DROP FOREIGN KEY FK_C0A1463987F4FB17');
        $this->addSql('DROP TABLE doctor');
        $this->addSql('DROP TABLE hospital');
        $this->addSql('DROP TABLE hospital_doctor');
        $this->addSql('DROP TABLE patient');
        $this->addSql('DROP TABLE rdv');
        $this->addSql('DROP TABLE service');
        $this->addSql('DROP TABLE messenger_messages');
    }
}

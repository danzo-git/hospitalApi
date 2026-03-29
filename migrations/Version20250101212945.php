<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250101212945 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE disponibilite (id INT AUTO_INCREMENT NOT NULL, medecin_id INT DEFAULT NULL, jour_semaine INT NOT NULL, heure_debut DATETIME NOT NULL, heure_fin DATETIME NOT NULL, INDEX IDX_2CBACE2F4F31A84 (medecin_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `doctor` (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, speciality VARCHAR(255) NOT NULL, grade VARCHAR(255) NOT NULL, year_of_experience INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE doctor_service (doctor_id INT NOT NULL, service_id INT NOT NULL, INDEX IDX_7230F97F87F4FB17 (doctor_id), INDEX IDX_7230F97FED5CA9E6 (service_id), PRIMARY KEY(doctor_id, service_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `hospital` (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, position VARCHAR(255) NOT NULL, image VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE hospital_doctor (hospital_id INT NOT NULL, doctor_id INT NOT NULL, INDEX IDX_C0A1463963DBB69 (hospital_id), INDEX IDX_C0A1463987F4FB17 (doctor_id), PRIMARY KEY(hospital_id, doctor_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE patient (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, first_name VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, number VARCHAR(255) NOT NULL, age INT NOT NULL, allergy VARCHAR(255) DEFAULT NULL, potential_illness VARCHAR(255) DEFAULT NULL, file VARCHAR(255) DEFAULT NULL, password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_1ADAD7EBE7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE patient_roles (patient_id INT NOT NULL, role_id INT NOT NULL, INDEX IDX_2308F5086B899279 (patient_id), INDEX IDX_2308F508D60322AC (role_id), PRIMARY KEY(patient_id, role_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `rdv` (id INT AUTO_INCREMENT NOT NULL, id_patient_id INT NOT NULL, service_id INT NOT NULL, doctor_id INT NOT NULL, INDEX IDX_10C31F86CE0312AE (id_patient_id), INDEX IDX_10C31F86ED5CA9E6 (service_id), INDEX IDX_10C31F8687F4FB17 (doctor_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE role (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_57698A6A5E237E06 (name), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `service` (id INT AUTO_INCREMENT NOT NULL, hopital_id INT NOT NULL, doctor_id INT NOT NULL, name VARCHAR(255) NOT NULL, status TINYINT(1) NOT NULL, subtitle VARCHAR(255) NOT NULL, image VARCHAR(255) DEFAULT NULL, price DOUBLE PRECISION DEFAULT NULL, INDEX IDX_E19D9AD2CC0FBF92 (hopital_id), INDEX IDX_E19D9AD287F4FB17 (doctor_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE disponibilite ADD CONSTRAINT FK_2CBACE2F4F31A84 FOREIGN KEY (medecin_id) REFERENCES `doctor` (id)');
        $this->addSql('ALTER TABLE doctor_service ADD CONSTRAINT FK_7230F97F87F4FB17 FOREIGN KEY (doctor_id) REFERENCES `doctor` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE doctor_service ADD CONSTRAINT FK_7230F97FED5CA9E6 FOREIGN KEY (service_id) REFERENCES `service` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE hospital_doctor ADD CONSTRAINT FK_C0A1463963DBB69 FOREIGN KEY (hospital_id) REFERENCES `hospital` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE hospital_doctor ADD CONSTRAINT FK_C0A1463987F4FB17 FOREIGN KEY (doctor_id) REFERENCES `doctor` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE patient_roles ADD CONSTRAINT FK_2308F5086B899279 FOREIGN KEY (patient_id) REFERENCES patient (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE patient_roles ADD CONSTRAINT FK_2308F508D60322AC FOREIGN KEY (role_id) REFERENCES role (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE `rdv` ADD CONSTRAINT FK_10C31F86CE0312AE FOREIGN KEY (id_patient_id) REFERENCES patient (id)');
        $this->addSql('ALTER TABLE `rdv` ADD CONSTRAINT FK_10C31F86ED5CA9E6 FOREIGN KEY (service_id) REFERENCES `service` (id)');
        $this->addSql('ALTER TABLE `rdv` ADD CONSTRAINT FK_10C31F8687F4FB17 FOREIGN KEY (doctor_id) REFERENCES `doctor` (id)');
        $this->addSql('ALTER TABLE `service` ADD CONSTRAINT FK_E19D9AD2CC0FBF92 FOREIGN KEY (hopital_id) REFERENCES `hospital` (id)');
        $this->addSql('ALTER TABLE `service` ADD CONSTRAINT FK_E19D9AD287F4FB17 FOREIGN KEY (doctor_id) REFERENCES `doctor` (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE disponibilite DROP FOREIGN KEY FK_2CBACE2F4F31A84');
        $this->addSql('ALTER TABLE doctor_service DROP FOREIGN KEY FK_7230F97F87F4FB17');
        $this->addSql('ALTER TABLE doctor_service DROP FOREIGN KEY FK_7230F97FED5CA9E6');
        $this->addSql('ALTER TABLE hospital_doctor DROP FOREIGN KEY FK_C0A1463963DBB69');
        $this->addSql('ALTER TABLE hospital_doctor DROP FOREIGN KEY FK_C0A1463987F4FB17');
        $this->addSql('ALTER TABLE patient_roles DROP FOREIGN KEY FK_2308F5086B899279');
        $this->addSql('ALTER TABLE patient_roles DROP FOREIGN KEY FK_2308F508D60322AC');
        $this->addSql('ALTER TABLE `rdv` DROP FOREIGN KEY FK_10C31F86CE0312AE');
        $this->addSql('ALTER TABLE `rdv` DROP FOREIGN KEY FK_10C31F86ED5CA9E6');
        $this->addSql('ALTER TABLE `rdv` DROP FOREIGN KEY FK_10C31F8687F4FB17');
        $this->addSql('ALTER TABLE `service` DROP FOREIGN KEY FK_E19D9AD2CC0FBF92');
        $this->addSql('ALTER TABLE `service` DROP FOREIGN KEY FK_E19D9AD287F4FB17');
        $this->addSql('DROP TABLE disponibilite');
        $this->addSql('DROP TABLE `doctor`');
        $this->addSql('DROP TABLE doctor_service');
        $this->addSql('DROP TABLE `hospital`');
        $this->addSql('DROP TABLE hospital_doctor');
        $this->addSql('DROP TABLE patient');
        $this->addSql('DROP TABLE patient_roles');
        $this->addSql('DROP TABLE `rdv`');
        $this->addSql('DROP TABLE role');
        $this->addSql('DROP TABLE `service`');
        $this->addSql('DROP TABLE messenger_messages');
    }
}

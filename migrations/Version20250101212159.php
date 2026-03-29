<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250101212159 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE doctor_service (doctor_id INT NOT NULL, service_id INT NOT NULL, INDEX IDX_7230F97F87F4FB17 (doctor_id), INDEX IDX_7230F97FED5CA9E6 (service_id), PRIMARY KEY(doctor_id, service_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE doctor_service ADD CONSTRAINT FK_7230F97F87F4FB17 FOREIGN KEY (doctor_id) REFERENCES `doctor` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE doctor_service ADD CONSTRAINT FK_7230F97FED5CA9E6 FOREIGN KEY (service_id) REFERENCES `service` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE service ADD doctor_id INT NOT NULL');
        $this->addSql('ALTER TABLE service ADD CONSTRAINT FK_E19D9AD287F4FB17 FOREIGN KEY (doctor_id) REFERENCES `doctor` (id)');
        $this->addSql('CREATE INDEX IDX_E19D9AD287F4FB17 ON service (doctor_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE doctor_service DROP FOREIGN KEY FK_7230F97F87F4FB17');
        $this->addSql('ALTER TABLE doctor_service DROP FOREIGN KEY FK_7230F97FED5CA9E6');
        $this->addSql('DROP TABLE doctor_service');
        $this->addSql('ALTER TABLE `service` DROP FOREIGN KEY FK_E19D9AD287F4FB17');
        $this->addSql('DROP INDEX IDX_E19D9AD287F4FB17 ON `service`');
        $this->addSql('ALTER TABLE `service` DROP doctor_id');
    }
}

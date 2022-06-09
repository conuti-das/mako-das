<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220608123906 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Initial migration';
    }

    public function up(Schema $schema): void
    {
        $this->addSql(
            'CREATE TABLE market_partner (id INT AUTO_INCREMENT NOT NULL, active INT NOT NULL, deleted INT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, type VARCHAR(255) NOT NULL, energy VARCHAR(255) NOT NULL, partner_id VARCHAR(255) NOT NULL, partner_id_type VARCHAR(255) DEFAULT NULL, partner_id_gmsb VARCHAR(255) DEFAULT NULL, organization VARCHAR(255) NOT NULL, zip VARCHAR(255) NOT NULL, city VARCHAR(100) NOT NULL, street VARCHAR(100) NOT NULL, house_number VARCHAR(35) DEFAULT NULL, iban VARCHAR(34) DEFAULT NULL, bic VARCHAR(15) DEFAULT NULL, bank VARCHAR(200) DEFAULT NULL, account_holder VARCHAR(50) DEFAULT NULL, phone VARCHAR(50) DEFAULT NULL, register_court VARCHAR(100) DEFAULT NULL, register_number VARCHAR(100) DEFAULT NULL, sign INT NOT NULL, compress INT NOT NULL, encrypt INT NOT NULL, reminder_email_address VARCHAR(255) NOT NULL, using_tum_catalog INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB;'
        );
        $this->addSql(
            'CREATE TABLE market_partner_import_log (id INT AUTO_INCREMENT NOT NULL, market_partner_id INT DEFAULT NULL, status VARCHAR(255) NOT NULL, message LONGTEXT DEFAULT NULL, created_at DATE NOT NULL, INDEX IDX_F4B79326FD6DACE2 (market_partner_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB;'
        );
        $this->addSql(
            'CREATE TABLE market_partner_email_import_log (id INT AUTO_INCREMENT NOT NULL, market_partner_email_id INT DEFAULT NULL, status VARCHAR(255) NOT NULL, message LONGTEXT DEFAULT NULL, created_at DATE NOT NULL, INDEX IDX_355D9F2356846B26 (market_partner_email_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB;'
        );
        $this->addSql(
            'CREATE TABLE `users` (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(100) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, UNIQUE INDEX UNIQ_1483A5E9F85E0677 (username), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB;'
        );
        $this->addSql(
            'CREATE TABLE market_partner_email (id INT AUTO_INCREMENT NOT NULL, market_partner_id INT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, email VARCHAR(255) NOT NULL, type VARCHAR(255) NOT NULL, ssl_certificate LONGTEXT DEFAULT NULL, ssl_certificate_expiration DATETIME DEFAULT NULL, active_from DATETIME NOT NULL, active_until DATETIME DEFAULT NULL, INDEX IDX_6540CD20FD6DACE2 (market_partner_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB;'
        );
        $this->addSql(
            'CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB;'
        );
        $this->addSql(
            'ALTER TABLE market_partner_import_log ADD CONSTRAINT FK_F4B79326FD6DACE2 FOREIGN KEY (market_partner_id) REFERENCES market_partner (id);'
        );
        $this->addSql(
            'ALTER TABLE market_partner_email_import_log ADD CONSTRAINT FK_355D9F2356846B26 FOREIGN KEY (market_partner_email_id) REFERENCES market_partner_email (id);'
        );
        $this->addSql(
            'ALTER TABLE market_partner_email ADD CONSTRAINT FK_6540CD20FD6DACE2 FOREIGN KEY (market_partner_id) REFERENCES market_partner (id);'
        );
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
    }
}

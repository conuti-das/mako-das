<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20220606074514 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE market_partner_email_import_log (id INT AUTO_INCREMENT NOT NULL, status INT NOT NULL, message LONGTEXT NOT NULL, created_at DATE DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE market_partner_import_log (id INT AUTO_INCREMENT NOT NULL, market_partner_id INT NOT NULL, status INT DEFAULT NULL, message LONGTEXT DEFAULT NULL, created_at DATE DEFAULT NULL, INDEX IDX_F4B79326FD6DACE2 (market_partner_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE market_partner_import_log ADD CONSTRAINT FK_F4B79326FD6DACE2 FOREIGN KEY (market_partner_id) REFERENCES market_partner (id)');
        $this->addSql('ALTER TABLE market_partner_email DROP updated_at');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE market_partner_email_import_log');
        $this->addSql('DROP TABLE market_partner_import_log');
        $this->addSql('ALTER TABLE market_partner_email ADD updated_at DATETIME DEFAULT NULL');
    }
}

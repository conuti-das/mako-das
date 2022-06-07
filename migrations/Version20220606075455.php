<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20220606075455 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE market_partner_email_import_log ADD market_partner_email_id INT NOT NULL');
        $this->addSql('ALTER TABLE market_partner_email_import_log ADD CONSTRAINT FK_355D9F2356846B26 FOREIGN KEY (market_partner_email_id) REFERENCES market_partner_email (id)');
        $this->addSql('CREATE INDEX IDX_355D9F2356846B26 ON market_partner_email_import_log (market_partner_email_id)');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE market_partner_email_import_log DROP FOREIGN KEY FK_355D9F2356846B26');
        $this->addSql('DROP INDEX IDX_355D9F2356846B26 ON market_partner_email_import_log');
        $this->addSql('ALTER TABLE market_partner_email_import_log DROP market_partner_email_id');
    }
}

<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20220530082709 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE market_partner_email ADD CONSTRAINT FK_6540CD20FD6DACE2 FOREIGN KEY (market_partner_id) REFERENCES market_partner (id)');
        $this->addSql('CREATE INDEX IDX_6540CD20FD6DACE2 ON market_partner_email (market_partner_id)');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE market_partner_email DROP FOREIGN KEY FK_6540CD20FD6DACE2');
        $this->addSql('DROP INDEX IDX_6540CD20FD6DACE2 ON market_partner_email');
    }
}

<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210730122735 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE note ADD usr_id INT NOT NULL');
        $this->addSql('ALTER TABLE note ADD CONSTRAINT FK_CFBDFA14C69D3FB FOREIGN KEY (usr_id) REFERENCES usr (id)');
        $this->addSql('CREATE INDEX IDX_CFBDFA14C69D3FB ON note (usr_id)');
        $this->addSql('ALTER TABLE usr CHANGE roles roles JSON NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE note DROP FOREIGN KEY FK_CFBDFA14C69D3FB');
        $this->addSql('DROP INDEX IDX_CFBDFA14C69D3FB ON note');
        $this->addSql('ALTER TABLE note DROP usr_id');
        $this->addSql('ALTER TABLE usr CHANGE roles roles LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_bin`');
    }
}

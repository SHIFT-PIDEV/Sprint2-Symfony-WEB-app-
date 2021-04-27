<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210426170857 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE client ADD roles JSON DEFAULT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_C7440455E7927C74 ON client (email)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX UNIQ_C7440455E7927C74 ON client');
        $this->addSql('ALTER TABLE client DROP roles');
        $this->addSql('ALTER TABLE commentaire DROP FOREIGN KEY FK_67F068BCA455ACCF');
        $this->addSql('ALTER TABLE commentaire DROP FOREIGN KEY FK_67F068BC2C6A49BA');
        $this->addSql('ALTER TABLE inscrievent DROP FOREIGN KEY FK_B1FA17F0A455ACCF');
        $this->addSql('ALTER TABLE inscrievent DROP FOREIGN KEY FK_B1FA17F02C6A49BA');
    }
}

<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210418134756 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE event CHANGE dateDebut dateDebut DATE DEFAULT NULL');
        $this->addSql('ALTER TABLE inscrievent RENAME INDEX fk_idclient TO IDX_B1FA17F0A455ACCF');
        $this->addSql('ALTER TABLE inscrievent RENAME INDEX fk_idevent TO IDX_B1FA17F02C6A49BA');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE event CHANGE dateDebut dateDebut DATE NOT NULL');
        $this->addSql('ALTER TABLE inscrievent DROP FOREIGN KEY FK_B1FA17F0A455ACCF');
        $this->addSql('ALTER TABLE inscrievent DROP FOREIGN KEY FK_B1FA17F02C6A49BA');
        $this->addSql('ALTER TABLE inscrievent RENAME INDEX idx_b1fa17f02c6a49ba TO fk_idevent');
        $this->addSql('ALTER TABLE inscrievent RENAME INDEX idx_b1fa17f0a455accf TO fk_idclient');
    }
}

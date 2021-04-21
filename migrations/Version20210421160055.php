<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210421160055 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE event CHANGE image image VARCHAR(500) DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE commentaire DROP FOREIGN KEY FK_67F068BCA455ACCF');
        $this->addSql('ALTER TABLE commentaire DROP FOREIGN KEY FK_67F068BC2C6A49BA');
        $this->addSql('ALTER TABLE event CHANGE image image VARCHAR(500) CHARACTER SET latin1 NOT NULL COLLATE `latin1_swedish_ci`');
        $this->addSql('ALTER TABLE inscrievent DROP FOREIGN KEY FK_B1FA17F0A455ACCF');
        $this->addSql('ALTER TABLE inscrievent DROP FOREIGN KEY FK_B1FA17F02C6A49BA');
    }
}

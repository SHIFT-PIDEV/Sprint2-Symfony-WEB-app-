<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210419155932 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE cour DROP FOREIGN KEY fn_categorie');
        $this->addSql('ALTER TABLE cour ADD updated_at DATETIME NOT NULL');
        $this->addSql('ALTER TABLE cour ADD CONSTRAINT FK_A71F964FC12C7510 FOREIGN KEY (id_c) REFERENCES categorie (id)');
        $this->addSql('ALTER TABLE package DROP FOREIGN KEY fn_categories');
        $this->addSql('ALTER TABLE package DROP FOREIGN KEY fn_packages');
        $this->addSql('ALTER TABLE package DROP FOREIGN KEY fn_packagess');
        $this->addSql('ALTER TABLE package DROP FOREIGN KEY fn_packagesss');
        $this->addSql('ALTER TABLE package ADD CONSTRAINT FK_DE6867955CD16DC3 FOREIGN KEY (idca) REFERENCES categorie (id)');
        $this->addSql('ALTER TABLE package ADD CONSTRAINT FK_DE68679564C3DD26 FOREIGN KEY (courp) REFERENCES cour (idCour)');
        $this->addSql('ALTER TABLE package ADD CONSTRAINT FK_DE686795506ED891 FOREIGN KEY (courpp) REFERENCES cour (idCour)');
        $this->addSql('ALTER TABLE package ADD CONSTRAINT FK_DE68679555F53BB FOREIGN KEY (courppp) REFERENCES cour (idCour)');
        $this->addSql('ALTER TABLE reclamation CHANGE id id INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE reponse DROP FOREIGN KEY fn_repC');
        $this->addSql('ALTER TABLE reponse CHANGE reponseC reponseC INT DEFAULT NULL');
        $this->addSql('ALTER TABLE reponse ADD CONSTRAINT FK_5FB6DEC738881E6A FOREIGN KEY (reponseC) REFERENCES question (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE cour DROP FOREIGN KEY FK_A71F964FC12C7510');
        $this->addSql('ALTER TABLE cour DROP updated_at');
        $this->addSql('ALTER TABLE cour ADD CONSTRAINT fn_categorie FOREIGN KEY (id_c) REFERENCES categorie (id) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE package DROP FOREIGN KEY FK_DE6867955CD16DC3');
        $this->addSql('ALTER TABLE package DROP FOREIGN KEY FK_DE68679564C3DD26');
        $this->addSql('ALTER TABLE package DROP FOREIGN KEY FK_DE686795506ED891');
        $this->addSql('ALTER TABLE package DROP FOREIGN KEY FK_DE68679555F53BB');
        $this->addSql('ALTER TABLE package ADD CONSTRAINT fn_categories FOREIGN KEY (idca) REFERENCES categorie (id) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE package ADD CONSTRAINT fn_packages FOREIGN KEY (courp) REFERENCES cour (idCour) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE package ADD CONSTRAINT fn_packagess FOREIGN KEY (courpp) REFERENCES cour (idCour) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE package ADD CONSTRAINT fn_packagesss FOREIGN KEY (courppp) REFERENCES cour (idCour) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE reclamation CHANGE id id INT NOT NULL');
        $this->addSql('ALTER TABLE reponse DROP FOREIGN KEY FK_5FB6DEC738881E6A');
        $this->addSql('ALTER TABLE reponse CHANGE reponseC reponseC INT NOT NULL');
        $this->addSql('ALTER TABLE reponse ADD CONSTRAINT fn_repC FOREIGN KEY (reponseC) REFERENCES question (id) ON UPDATE CASCADE ON DELETE CASCADE');
    }
}

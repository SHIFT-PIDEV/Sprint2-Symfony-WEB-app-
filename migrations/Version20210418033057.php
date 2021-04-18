<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210418033057 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE demande CHANGE id id INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE examen DROP FOREIGN KEY fn_q');
        $this->addSql('ALTER TABLE examen DROP FOREIGN KEY fn_qq');
        $this->addSql('ALTER TABLE examen DROP FOREIGN KEY fn_qqq');
        $this->addSql('ALTER TABLE examen ADD CONSTRAINT FK_514C8FECF500AE27 FOREIGN KEY (q) REFERENCES question (id)');
        $this->addSql('ALTER TABLE examen ADD CONSTRAINT FK_514C8FEC50FF1BE2 FOREIGN KEY (qq) REFERENCES question (id)');
        $this->addSql('ALTER TABLE examen ADD CONSTRAINT FK_514C8FECBB54D268 FOREIGN KEY (qqq) REFERENCES question (id)');
        $this->addSql('ALTER TABLE inscripexam DROP FOREIGN KEY fk_examen');
        $this->addSql('ALTER TABLE inscripexam CHANGE idExam idExam INT DEFAULT NULL');
        $this->addSql('ALTER TABLE inscripexam ADD CONSTRAINT FK_AC5B735FA455ACCF FOREIGN KEY (idClient) REFERENCES client (id)');
        $this->addSql('ALTER TABLE inscripexam ADD CONSTRAINT FK_AC5B735F4B46F858 FOREIGN KEY (idExam) REFERENCES examen (id)');
        $this->addSql('CREATE INDEX IDX_AC5B735FA455ACCF ON inscripexam (idClient)');
        $this->addSql('ALTER TABLE reclamation CHANGE id id INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE reponse DROP FOREIGN KEY fn_repC');
        $this->addSql('ALTER TABLE reponse CHANGE reponseC reponseC INT DEFAULT NULL');
        $this->addSql('ALTER TABLE reponse ADD CONSTRAINT FK_5FB6DEC738881E6A FOREIGN KEY (reponseC) REFERENCES question (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE demande CHANGE id id INT NOT NULL');
        $this->addSql('ALTER TABLE examen DROP FOREIGN KEY FK_514C8FECF500AE27');
        $this->addSql('ALTER TABLE examen DROP FOREIGN KEY FK_514C8FEC50FF1BE2');
        $this->addSql('ALTER TABLE examen DROP FOREIGN KEY FK_514C8FECBB54D268');
        $this->addSql('ALTER TABLE examen ADD CONSTRAINT fn_q FOREIGN KEY (q) REFERENCES question (id) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE examen ADD CONSTRAINT fn_qq FOREIGN KEY (qq) REFERENCES question (id) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE examen ADD CONSTRAINT fn_qqq FOREIGN KEY (qqq) REFERENCES question (id) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE inscripexam DROP FOREIGN KEY FK_AC5B735FA455ACCF');
        $this->addSql('ALTER TABLE inscripexam DROP FOREIGN KEY FK_AC5B735F4B46F858');
        $this->addSql('DROP INDEX IDX_AC5B735FA455ACCF ON inscripexam');
        $this->addSql('ALTER TABLE inscripexam CHANGE idExam idExam INT NOT NULL');
        $this->addSql('ALTER TABLE inscripexam ADD CONSTRAINT fk_examen FOREIGN KEY (idExam) REFERENCES examen (id) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE reclamation CHANGE id id INT NOT NULL');
        $this->addSql('ALTER TABLE reponse DROP FOREIGN KEY FK_5FB6DEC738881E6A');
        $this->addSql('ALTER TABLE reponse CHANGE reponseC reponseC INT NOT NULL');
        $this->addSql('ALTER TABLE reponse ADD CONSTRAINT fn_repC FOREIGN KEY (reponseC) REFERENCES question (id) ON UPDATE CASCADE ON DELETE CASCADE');
    }
}

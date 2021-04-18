<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Inscripexam
 *
 * @ORM\Table(name="inscripexam")
 * @ORM\Entity
 */
class Inscripexam
{
    /**
     * @var int
     *
     * @ORM\Column(name="idinscri", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idinscri;

    /**
     * @var int
     *
     * @ORM\Column(name="idClient", type="integer", nullable=false)
     */
    private $idclient;

    /**
     * @var int
     *
     * @ORM\Column(name="idExam", type="integer", nullable=false)
     */
    private $idexam;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateInscri", type="date", nullable=false)
     */
    private $dateinscri;

    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=255, nullable=false)
     */
    private $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="prenom", type="string", length=255, nullable=false)
     */
    private $prenom;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255, nullable=false)
     */
    private $email;


}

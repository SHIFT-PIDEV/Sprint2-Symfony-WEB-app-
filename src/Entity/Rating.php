<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Rating
 *
 * @ORM\Table(name="rating")
 * @ORM\Entity
 */
class Rating
{
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
     * @var int
     *
     * @ORM\Column(name="idR", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idr;

    /**
     * @var string
     *
     * @ORM\Column(name="commentaire", type="string", length=255, nullable=false)
     */
    private $commentaire;

    /**
     * @var int
     *
     * @ORM\Column(name="rate", type="integer", nullable=false)
     */
    private $rate;


}

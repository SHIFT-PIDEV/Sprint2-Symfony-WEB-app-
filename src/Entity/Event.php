<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Event
 *
 * @ORM\Table(name="event")
 * @ORM\Entity
 */
class Event
{
    /**
     * @var int
     *
     * @ORM\Column(name="idEvent", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idevent;

    /**
     * @var int
     *
     * @ORM\Column(name="idFormateur", type="integer", nullable=false)
     */
    private $idformateur;

    /**
     * @var string
     *
     * @ORM\Column(name="nomEvent", type="string", length=100, nullable=false)
     */
    private $nomevent;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateDebut", type="date", nullable=false)
     */
    private $datedebut;

    /**
     * @var int
     *
     * @ORM\Column(name="heure", type="integer", nullable=false)
     */
    private $heure;

    /**
     * @var int
     *
     * @ORM\Column(name="duree", type="integer", nullable=false)
     */
    private $duree;

    /**
     * @var string
     *
     * @ORM\Column(name="descEvent", type="string", length=500, nullable=false)
     */
    private $descevent;

    /**
     * @var string
     *
     * @ORM\Column(name="image", type="string", length=500, nullable=false)
     */
    private $image;


}

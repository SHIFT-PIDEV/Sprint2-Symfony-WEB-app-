<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Inscrievent
 *
 * @ORM\Table(name="inscrievent", indexes={@ORM\Index(name="fk_idclient", columns={"idClient"})})
 * @ORM\Entity
 */
class Inscrievent
{
    /**
     * @var int
     *
     * @ORM\Column(name="idInscri", type="integer", nullable=false)
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
     * @ORM\Column(name="idEvent", type="integer", nullable=false)
     */
    private $idevent;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateInscri", type="datetime", nullable=false, options={"default"="CURRENT_TIMESTAMP"})
     */
    private $dateinscri = 'CURRENT_TIMESTAMP';


}

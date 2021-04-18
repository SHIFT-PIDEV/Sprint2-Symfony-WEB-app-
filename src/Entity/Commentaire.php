<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Commentaire
 *
 * @ORM\Table(name="commentaire")
 * @ORM\Entity
 */
class Commentaire
{
    /**
     * @var int
     *
     * @ORM\Column(name="idComm", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idcomm;

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
     * @ORM\Column(name="dateComm", type="datetime", nullable=false, options={"default"="CURRENT_TIMESTAMP"})
     */
    private $datecomm = 'CURRENT_TIMESTAMP';

    /**
     * @var string
     *
     * @ORM\Column(name="descComm", type="string", length=500, nullable=false)
     */
    private $desccomm;


}

<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Commentairepack
 *
 * @ORM\Table(name="commentairepack")
 * @ORM\Entity
 */
class Commentairepack
{
    /**
     * @var int
     *
     * @ORM\Column(name="idcomm", type="integer", nullable=false)
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
     * @ORM\Column(name="idpackage", type="integer", nullable=false)
     */
    private $idpackage;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="datecomm", type="datetime", nullable=false, options={"default"="CURRENT_TIMESTAMP"})
     */
    private $datecomm = 'CURRENT_TIMESTAMP';

    /**
     * @var string
     *
     * @ORM\Column(name="descComm", type="string", length=500, nullable=false)
     */
    private $desccomm;


}

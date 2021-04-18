<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Likeevent
 *
 * @ORM\Table(name="likeevent", indexes={@ORM\Index(name="fk_idc", columns={"idEvent"})})
 * @ORM\Entity
 */
class Likeevent
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var int
     *
     * @ORM\Column(name="idEvent", type="integer", nullable=false)
     */
    private $idevent;

    /**
     * @var int
     *
     * @ORM\Column(name="idClient", type="integer", nullable=false)
     */
    private $idclient;


}

<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Notification
 *
 * @ORM\Table(name="notification")
 * @ORM\Entity
 */
class Notification
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
     * @ORM\Column(name="idcs", type="integer", nullable=false)
     */
    private $idcs;

    /**
     * @var int
     *
     * @ORM\Column(name="idcd", type="integer", nullable=false)
     */
    private $idcd;

    /**
     * @var int
     *
     * @ORM\Column(name="idevent", type="integer", nullable=false)
     */
    private $idevent;


}

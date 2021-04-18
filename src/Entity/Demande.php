<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Demande
 *
 * @ORM\Table(name="demande")
 * @ORM\Entity
 */
class Demande
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
     * @var string
     *
     * @ORM\Column(name="objet", type="string", length=225, nullable=false)
     */
    private $objet;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=225, nullable=false)
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="cv", type="string", length=225, nullable=false)
     */
    private $cv;


}

<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Cour
 *
 * @ORM\Table(name="cour")
 * @ORM\Entity
 */
class Cour
{
    /**
     * @var int
     *
     * @ORM\Column(name="idCour", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idcour;

    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=255, nullable=false)
     */
    private $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="nomcat", type="string", length=255, nullable=false)
     */
    private $nomcat;

    /**
     * @var string
     *
     * @ORM\Column(name="formateur", type="string", length=255, nullable=false)
     */
    private $formateur;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255, nullable=false)
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="img", type="string", length=255, nullable=false)
     */
    private $img;

    /**
     * @var float
     *
     * @ORM\Column(name="prix", type="float", precision=10, scale=0, nullable=false)
     */
    private $prix;

    /**
     * @var string
     *
     * @ORM\Column(name="niveau", type="string", length=255, nullable=false)
     */
    private $niveau;

    /**
     * @var string
     *
     * @ORM\Column(name="duration", type="string", length=255, nullable=false)
     */
    private $duration;


}

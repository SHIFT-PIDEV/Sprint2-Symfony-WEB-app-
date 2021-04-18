<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Package
 *
 * @ORM\Table(name="package")
 * @ORM\Entity
 */
class Package
{
    /**
     * @var int
     *
     * @ORM\Column(name="idpackage", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idpackage;

    /**
     * @var string
     *
     * @ORM\Column(name="nompackage", type="string", length=255, nullable=false)
     */
    private $nompackage;

    /**
     * @var float
     *
     * @ORM\Column(name="prix", type="float", precision=10, scale=0, nullable=false)
     */
    private $prix;

    /**
     * @var string
     *
     * @ORM\Column(name="duree", type="string", length=255, nullable=false)
     */
    private $duree;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255, nullable=false)
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="categorie", type="string", length=255, nullable=false)
     */
    private $categorie;

    /**
     * @var string
     *
     * @ORM\Column(name="image", type="string", length=255, nullable=false)
     */
    private $image;

    /**
     * @var int
     *
     * @ORM\Column(name="nbrcours", type="integer", nullable=false)
     */
    private $nbrcours;


}

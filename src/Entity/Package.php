<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Package
 *
 * @ORM\Table(name="package", indexes={@ORM\Index(name="fn_packagesss", columns={"courppp"}), @ORM\Index(name="fn_categories", columns={"idca"}), @ORM\Index(name="fn_packages", columns={"courp"}), @ORM\Index(name="fn_packagess", columns={"courpp"})})
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
     * @var string|null
     *
     * @ORM\Column(name="categorie", type="string", length=255, nullable=true)
     */
    private $categorie;

    /**
     * @var string|null
     *
     * @ORM\Column(name="image", type="string", length=255, nullable=true)
     */
    private $image;

    /**
     * @var int
     *
     * @ORM\Column(name="nbrcours", type="integer", nullable=false)
     */
    private $nbrcours;

    /**
     * @var \Categorie
     *
     * @ORM\ManyToOne(targetEntity="Categorie")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idca", referencedColumnName="id")
     * })
     */
    private $idca;

    /**
     * @var \Cour
     *
     * @ORM\ManyToOne(targetEntity="Cour")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="courp", referencedColumnName="idCour")
     * })
     */
    private $courp;

    /**
     * @var \Cour
     *
     * @ORM\ManyToOne(targetEntity="Cour")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="courpp", referencedColumnName="idCour")
     * })
     */
    private $courpp;

    /**
     * @var \Cour
     *
     * @ORM\ManyToOne(targetEntity="Cour")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="courppp", referencedColumnName="idCour")
     * })
     */
    private $courppp;

    public function getIdpackage(): ?int
    {
        return $this->idpackage;
    }

    public function getNompackage(): ?string
    {
        return $this->nompackage;
    }

    public function setNompackage(string $nompackage): self
    {
        $this->nompackage = $nompackage;

        return $this;
    }

    public function getPrix(): ?float
    {
        return $this->prix;
    }

    public function setPrix(float $prix): self
    {
        $this->prix = $prix;

        return $this;
    }

    public function getDuree(): ?string
    {
        return $this->duree;
    }

    public function setDuree(string $duree): self
    {
        $this->duree = $duree;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getCategorie(): ?string
    {
        return $this->categorie;
    }

    public function setCategorie(?string $categorie): self
    {
        $this->categorie = $categorie;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getNbrcours(): ?int
    {
        return $this->nbrcours;
    }

    public function setNbrcours(int $nbrcours): self
    {
        $this->nbrcours = $nbrcours;

        return $this;
    }

    public function getIdca(): ?Categorie
    {
        return $this->idca;
    }

    public function setIdca(?Categorie $idca): self
    {
        $this->idca = $idca;

        return $this;
    }

    public function getCourp(): ?Cour
    {
        return $this->courp;
    }

    public function setCourp(?Cour $courp): self
    {
        $this->courp = $courp;

        return $this;
    }

    public function getCourpp(): ?Cour
    {
        return $this->courpp;
    }

    public function setCourpp(?Cour $courpp): self
    {
        $this->courpp = $courpp;

        return $this;
    }

    public function getCourppp(): ?Cour
    {
        return $this->courppp;
    }

    public function setCourppp(?Cour $courppp): self
    {
        $this->courppp = $courppp;

        return $this;
    }


}

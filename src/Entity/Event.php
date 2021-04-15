<?php

namespace App\Entity;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="event")
 * @ORM\Entity(repositoryClass="App\Repository\EventRepository")
 */
class Event
{

    public function __construct(){

    }
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
     *@Assert\NotNull(message="id formateur is required!")
     * @ORM\Column(name="idFormateur", type="integer", nullable=false)
     */
    private $idformateur;

    /**
     * @var string
     * @Assert\NotNull(message="Event name is required!")
     * @ORM\Column(name="nomEvent", type="string", length=100, nullable=false)
     */
    private $nomevent;

    /**
     * @var \DateTime
     * @Assert\NotNull(message="Date is required!")
     * @Assert\GreaterThanOrEqual("today",message="Date should be greater than today")
     * @ORM\Column(name="dateDebut", type="date", nullable=true)
     */
    private $datedebut;

    /**
     * @var int
     * @Assert\Range(
     * min=0,
     * max=23,
     *    notInRangeMessage="verifier l'heure !"
     * )
     * @Assert\NotNull(message="hour of Event is required!")
     * @ORM\Column(name="heure", type="integer", nullable=false)
     */
    private $heure;

    /**
     * @var int
     * @Assert\Positive(message="check the duration")
     * @Assert\NotNull (message="Duration is required!")
     * @ORM\Column(name="duree", type="integer", nullable=false)
     */
    private $duree;

    /**
     * @var string
     * @Assert\NotNull (message="Description is required!")
     * @ORM\Column(name="descEvent", type="text",nullable=false)
     */
    private $descevent;

    /**
     * @var string
     *
     * @ORM\Column(name="image", type="string", length=500, nullable=false)
     */
    private $image;

    public function getIdevent(): ?int
    {
        return $this->idevent;
    }

    public function getIdformateur(): ?int
    {
        return $this->idformateur;
    }

    public function setIdformateur(int $idformateur): self
    {
        $this->idformateur = $idformateur;

        return $this;
    }

    public function getNomevent(): ?string
    {
        return $this->nomevent;
    }

    public function setNomevent(string $nomevent): self
    {
        $this->nomevent = $nomevent;

        return $this;
    }

    public function getDatedebut(): ?\DateTimeInterface
    {
        return $this->datedebut;
    }

    public function setDatedebut(\DateTimeInterface $datedebut): self
    {
        $this->datedebut = $datedebut;

        return $this;
    }

    public function getHeure(): ?int
    {
        return $this->heure;
    }

    public function setHeure(int $heure): self
    {
        $this->heure = $heure;

        return $this;
    }

    public function getDuree(): ?int
    {
        return $this->duree;
    }

    public function setDuree(int $duree): self
    {
        $this->duree = $duree;

        return $this;
    }

    public function getDescevent(): ?string
    {
        return $this->descevent;
    }

    public function setDescevent(string $descevent): self
    {
        $this->descevent = $descevent;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): self
    {
        $this->image = $image;

        return $this;
    }


}

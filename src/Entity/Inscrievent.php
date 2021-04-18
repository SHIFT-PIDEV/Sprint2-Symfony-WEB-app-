<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Inscrievent
 *
 * @ORM\Table(name="inscrievent", indexes={@ORM\Index(name="fk_idevent", columns={"idEvent"}), @ORM\Index(name="fk_idclient", columns={"idClient"})})
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
     * @ORM\Column(name="dateInscri", type="datetime", nullable=false)
     */
    private $dateinscri;

    public function getIdinscri(): ?int
    {
        return $this->idinscri;
    }

    public function getIdclient(): ?int
    {
        return $this->idclient;
    }

    public function setIdclient(int $idclient): self
    {
        $this->idclient = $idclient;

        return $this;
    }

    public function getIdevent(): ?int
    {
        return $this->idevent;
    }

    public function setIdevent(int $idevent): self
    {
        $this->idevent = $idevent;

        return $this;
    }

    public function getDateinscri(): ?\DateTimeInterface
    {
        return $this->dateinscri;
    }

    public function setDateinscri(\DateTimeInterface $dateinscri): self
    {
        $this->dateinscri = $dateinscri;

        return $this;
    }


}

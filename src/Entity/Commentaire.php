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
     * @ORM\Column(name="dateComm", type="datetime", nullable=false)
     */
    private $datecomm;

    /**
     * @var string
     *
     * @ORM\Column(name="descComm", type="string", length=500, nullable=false)
     */
    private $desccomm;

    public function getIdcomm(): ?int
    {
        return $this->idcomm;
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

    public function getDatecomm(): ?\DateTimeInterface
    {
        return $this->datecomm;
    }

    public function setDatecomm(\DateTimeInterface $datecomm): self
    {
        $this->datecomm = $datecomm;

        return $this;
    }

    public function getDesccomm(): ?string
    {
        return $this->desccomm;
    }

    public function setDesccomm(string $desccomm): self
    {
        $this->desccomm = $desccomm;

        return $this;
    }


}

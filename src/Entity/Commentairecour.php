<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Commentairecour
 *
 * @ORM\Table(name="commentairecour")
 * @ORM\Entity
 */
class Commentairecour
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
     * @ORM\Column(name="idCour", type="integer", nullable=false)
     */
    private $idcour;

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

    public function getIdcour(): ?int
    {
        return $this->idcour;
    }

    public function setIdcour(int $idcour): self
    {
        $this->idcour = $idcour;

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

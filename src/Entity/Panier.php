<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Panier
 *
 * @ORM\Table(name="panier")
 * @ORM\Entity
 */
class Panier
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
     * @ORM\Column(name="idcour", type="integer", nullable=false)
     */
    private $idcour;

    /**
     * @var int
     *
     * @ORM\Column(name="idclient", type="integer", nullable=false)
     */
    private $idclient;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getIdclient(): ?int
    {
        return $this->idclient;
    }

    public function setIdclient(int $idclient): self
    {
        $this->idclient = $idclient;

        return $this;
    }


}

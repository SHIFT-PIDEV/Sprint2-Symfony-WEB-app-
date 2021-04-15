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
     * @ORM\Column(name="idnotif", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idnotif;

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

    public function getIdnotif(): ?int
    {
        return $this->idnotif;
    }

    public function getIdcs(): ?int
    {
        return $this->idcs;
    }

    public function setIdcs(int $idcs): self
    {
        $this->idcs = $idcs;

        return $this;
    }

    public function getIdcd(): ?int
    {
        return $this->idcd;
    }

    public function setIdcd(int $idcd): self
    {
        $this->idcd = $idcd;

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


}

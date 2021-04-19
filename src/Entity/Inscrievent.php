<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Inscrievent
 *@ORM\Entity(repositoryClass="App\Repository\InscrieventRepository")
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
     * @var \DateTime
     *
     * @ORM\Column(name="dateInscri", type="datetime", nullable=false)
     */
    private $dateinscri;

    /**
     *@ORM\ManyToOne (targetEntity=Client::class,inversedBy="inscriptions")
     * @ORM\JoinColumn(name="idClient", referencedColumnName="id",nullable=false)
     */
    private $client;

    /**
     * @ORM\ManyToOne (targetEntity=Event::class,inversedBy="inscriptions")
     * @ORM\JoinColumn(name="idEvent", referencedColumnName="idEvent",nullable=false)
     */
    private $event;

    public function getIdinscri(): ?int
    {
        return $this->idinscri;
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

    public function getClient(): ?Client
    {
        return $this->client;
    }

    public function setClient(?Client $client): self
    {
        $this->client = $client;

        return $this;
    }

    public function getEvent(): ?Event
    {
        return $this->event;
    }

    public function setEvent(?Event $event): self
    {
        $this->event = $event;

        return $this;
    }


}

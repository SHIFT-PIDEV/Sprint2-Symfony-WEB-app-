<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Commentaire
 *@ORM\Entity(repositoryClass="App\Repository\CommentaireRepository")
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
     * @var \DateTime
     *
     * @ORM\Column(name="dateComm", type="datetime", nullable=false)
     */
    private $datecomm;

    /**
     * @var string
     * @ORM\Column(name="descComm", type="text", nullable=false)
     */
    private $desccomm;
    /**
     * @ORM\ManyToOne(targetEntity=Client::class,inversedBy="comms")
     * @ORM\JoinColumn(name="idClient",referencedColumnName="id",nullable=false)
     */
    private $client;
    /**
     * @ORM\ManyToOne (targetEntity=Event::class,inversedBy="comms")
     * @ORM\JoinColumn(name="idEvent", referencedColumnName="idEvent",nullable=false)
     */
    private $event;

    public function getIdcomm(): ?int
    {
        return $this->idcomm;
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

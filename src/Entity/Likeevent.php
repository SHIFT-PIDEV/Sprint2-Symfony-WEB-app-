<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
/**
 * Likeevent
 *
 * @ORM\Table(name="likeevent", indexes={@ORM\Index(name="fk_idc", columns={"idEvent"})})
 * @ORM\Entity(repositoryClass="App\Repository\LikeRepository")
 */
class Likeevent
{
    /**
     * @var int
     *
     * @ORM\Column(name="idlike", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @Groups ("like")
     */
    private $idlike;

    /**
     *@ORM\ManyToOne (targetEntity=Client::class,inversedBy="likes")
     * @ORM\JoinColumn(name="idClient", referencedColumnName="id",nullable=false)
     */
    private $client;

    /**
     * @ORM\ManyToOne (targetEntity=Event::class,inversedBy="likes")
     * @ORM\JoinColumn(name="idEvent", referencedColumnName="idEvent",nullable=false)
     */
    private $event;

    public function getIdlike(): ?int
    {
        return $this->idlike;
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

    public function getIdclient(): ?int
    {
        return $this->idclient;
    }

    public function setIdclient(int $idclient): self
    {
        $this->idclient = $idclient;

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

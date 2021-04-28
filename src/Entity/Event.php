<?php

namespace App\Entity;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Event
 *
 * @ORM\Table(name="event")
 * @ORM\Entity
 */
class Event
{
    /**
     * @var int
     * @ORM\Column(name="idEvent", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idevent;

    /**
     * @var int
     * @Assert\NotNull(message="idformateur is required!")
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
     * @var \DateTime|null
     *@Assert\NotNull(message="Date is required!")
     * @Assert\GreaterThanOrEqual("today",message="Date should be greater than today!")
     * @ORM\Column(name="dateDebut", type="date", nullable=true)
     */
    private $datedebut;

    /**
     * @var int
     *@Assert\NotNull(message="Hour is required!")
     * @Assert\Range(min=0,max=23,notInRangeMessage="check the hour!")
     * @ORM\Column(name="heure", type="integer", nullable=false)
     */
    private $heure;

    /**
     * @var int
     *@Assert\NotNull(message="Duration is required!")
     * @Assert\Positive(message="check the duration!")
     * @ORM\Column(name="duree", type="integer", nullable=false)
     */
    private $duree;

    /**
     * @var string
     * @Assert\NotNull (message="Description is required!")
     * @ORM\Column(name="descEvent", type="text", nullable=false)
     */
    private $descevent;

    /**
     * @var string
     *
     * @ORM\Column(name="image", type="string", length=500, nullable=true)
     */
    private $image;


    /**
     * @ORM\OneToMany(targetEntity=Inscrievent::class,mappedBy="event",cascade={"all"},orphanRemoval=true)
     */
    private $inscriptions;
    /**
     * @ORM\OneToMany(targetEntity=Commentaire::class,mappedBy="event",cascade={"all"},orphanRemoval=true)
     */
    private $comms;

    /**
     * @ORM\OneToMany (targetEntity=Likeevent::class,mappedBy="event",cascade={"all"},orphanRemoval=true)
     */
    private $likes;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $pic;


    public function __construct()
    {
        $this->inscriptions = new ArrayCollection();
        $this->comms = new ArrayCollection();
        $this->likes = new ArrayCollection();
    }


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

    public function setDatedebut(?\DateTimeInterface $datedebut): self
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

    /**
     * @return Collection|Inscrievent[]
     */
    public function getInscriptions(): Collection
    {
        return $this->inscriptions;
    }

    public function addInscription(Inscrievent $inscription): self
    {
        if (!$this->inscriptions->contains($inscription)) {
            $this->inscriptions[] = $inscription;
            $inscription->setEvent($this);
        }

        return $this;
    }

    public function removeInscription(Inscrievent $inscription): self
    {
        if ($this->inscriptions->removeElement($inscription)) {
            // set the owning side to null (unless already changed)
            if ($inscription->getEvent() === $this) {
                $inscription->setEvent(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Commentaire[]
     */
    public function getComms(): Collection
    {
        return $this->comms;
    }

    public function addComm(Commentaire $comm): self
    {
        if (!$this->comms->contains($comm)) {
            $this->comms[] = $comm;
            $comm->setEvent($this);
        }

        return $this;
    }

    public function removeComm(Commentaire $comm): self
    {
        if ($this->comms->removeElement($comm)) {
            // set the owning side to null (unless already changed)
            if ($comm->getEvent() === $this) {
                $comm->setEvent(null);
            }
        }

        return $this;
    }

    public function getPic(): ?string
    {
        return $this->pic;
    }

    public function setPic(?string $pic): self
    {
        $this->pic = $pic;

        return $this;
    }

    /**
     * @return Collection|Likeevent[]
     */
    public function getLikes(): Collection
    {
        return $this->likes;
    }

    public function addLike(Likeevent $like): self
    {
        if (!$this->likes->contains($like)) {
            $this->likes[] = $like;
            $like->setEvent($this);
        }

        return $this;
    }

    public function removeLike(Likeevent $like): self
    {
        if ($this->likes->removeElement($like)) {
            // set the owning side to null (unless already changed)
            if ($like->getEvent() === $this) {
                $like->setEvent(null);
            }
        }

        return $this;
    }

    /**
     * @param Client $client
     * @return bool
     */
    public function isLikedByUser(Client $client):bool{
        foreach ($this->likes as $like){
            if($like->getClient()===$client) return true;
        }
        return false;
    }


}

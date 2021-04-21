<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Client
 *
 * @ORM\Table(name="client")
 * *@ORM\Entity(repositoryClass="App\Repository\ClientRepository")
 */
class Client
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
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=50, nullable=false)
     */
    private $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="prenom", type="string", length=50, nullable=false)
     */
    private $prenom;

    /**
     * @var string
     *
     * @ORM\Column(name="userName", type="string", length=50, nullable=false)
     */
    private $username;

    /**
     * @var string
     *
     * @ORM\Column(name="mdp", type="string", length=50, nullable=false)
     */
    private $mdp;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=50, nullable=false)
     */
    private $email;

    /**
     * @var int|null
     *
     * @ORM\Column(name="nbrnotif", type="integer", nullable=true)
     */
    private $nbrnotif;

    /**
     * @ORM\OneToMany(targetEntity=Inscrievent::class,mappedBy="client",cascade={"all"},orphanRemoval=true)
     */
    private $inscriptions;
    /**
     * @ORM\OneToMany(targetEntity=Commentaire::class,mappedBy="client",cascade={"all"},orphanRemoval=true)
     */
    private $comms;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $pic;

    public function __construct()
    {
        $this->inscriptions = new ArrayCollection();
        $this->comms = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function getMdp(): ?string
    {
        return $this->mdp;
    }

    public function setMdp(string $mdp): self
    {
        $this->mdp = $mdp;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getNbrnotif(): ?int
    {
        return $this->nbrnotif;
    }

    public function setNbrnotif(?int $nbrnotif): self
    {
        $this->nbrnotif = $nbrnotif;

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
            $inscription->setClient($this);
        }

        return $this;
    }

    public function removeInscription(Inscrievent $inscription): self
    {
        if ($this->inscriptions->removeElement($inscription)) {
            // set the owning side to null (unless already changed)
            if ($inscription->getClient() === $this) {
                $inscription->setClient(null);
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
            $comm->setClient($this);
        }

        return $this;
    }

    public function removeComm(Commentaire $comm): self
    {
        if ($this->comms->removeElement($comm)) {
            // set the owning side to null (unless already changed)
            if ($comm->getClient() === $this) {
                $comm->setClient(null);
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


}

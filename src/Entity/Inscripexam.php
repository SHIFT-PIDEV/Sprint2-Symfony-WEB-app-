<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Inscripexam
 *
 * @ORM\Table(name="inscripexam")
 * @ORM\Entity
 */
class Inscripexam
{
    /**
     * @var int
     *
     * @ORM\Column(name="idinscri", type="integer", nullable=false)
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
     * @ORM\Column(name="idExam", type="integer", nullable=false)
     */
    private $idexam;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateInscri", type="date", nullable=false)
     */
    private $dateinscri;

    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=255, nullable=false)
     */
    private $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="prenom", type="string", length=255, nullable=false)
     */
    private $prenom;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255, nullable=false)
     */
    private $email;

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

    public function getIdexam(): ?int
    {
        return $this->idexam;
    }

    public function setIdexam(int $idexam): self
    {
        $this->idexam = $idexam;

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

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }


}

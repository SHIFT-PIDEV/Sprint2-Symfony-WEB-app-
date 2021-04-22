<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Inscripexam
 *
 * @ORM\Table(name="inscripexam", indexes={@ORM\Index(name="fk_examen", columns={"idExam"})})
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
     * @var int|null
     ** @ORM\ManyToOne(targetEntity="Client")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idClient", referencedColumnName="id")
     * })
     */
    private $idclient;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateInscri", type="date", nullable=false)
     */
    private $dateinscri;

    /**
     * @return int
     */
    public function getIdinscri(): int
    {
        return $this->idinscri;
    }

    /**
     * @param int $idinscri
     */
    public function setIdinscri(int $idinscri): void
    {
        $this->idinscri = $idinscri;
    }

    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=255, nullable=false)
     * @Assert\NotBlank(message="le champs nom de doit pas etre vide ")
     * @Assert\Length(
     *      min = 5,
     *      max = 30,
     *      minMessage = "Le Nom correct doit comporter au minimum {{ limit }} characters",
     *      maxMessage = "Le Nom correct ne doit pas depasser {{ limit }} characters",
     *      allowEmptyString = false
     *     )
     */
    private $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="prenom", type="string", length=255, nullable=false)
     * @Assert\NotBlank(message="le champs prénom de doit pas etre vide ")
     * @Assert\Length(
     *      min = 5,
     *      max = 30,
     *      minMessage = "Le Prénom correct doit comporter au minimum {{ limit }} characters",
     *      maxMessage = "Le Prénom correct ne doit pas depasser {{ limit }} characters",
     *      allowEmptyString = false
     *     )
     */
    private $prenom;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255, nullable=false)
     *  * @Assert\Email(
     *     message = "The email '{{ value }}' is not a valid email."
     * )
     * @Assert\NotBlank(message="le champs Email de doit pas etre vide ")
     */
    private $email;

    /**
     * @var \Examen
     *
     * @ORM\ManyToOne(targetEntity="Examen")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idExam", referencedColumnName="id")
     * })
     */
    private $idexam;

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

    public function getIdclient(): ?Client
    {
        return $this->idclient;
    }

    public function setIdclient(?Client $idclient): self
    {
        $this->idclient = $idclient;

        return $this;
    }

    public function getIdexam(): ?Examen
    {
        return $this->idexam;
    }

    public function setIdexam(?Examen $idexam): self
    {
        $this->idexam = $idexam;

        return $this;
    }
    public function __construct()
    {
        $this->dateinscri = new \DateTime('now');


    }
    protected $captchaCode;

    public function getCaptchaCode()
    {
        return $this->captchaCode;
    }

    public function setCaptchaCode($captchaCode)
    {
        $this->captchaCode = $captchaCode;
    }
}

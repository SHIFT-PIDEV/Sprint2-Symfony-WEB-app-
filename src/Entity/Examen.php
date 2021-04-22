<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Examen
 *
 * @ORM\Table(name="examen", indexes={@ORM\Index(name="fn_qq", columns={"qq"}), @ORM\Index(name="fn_q", columns={"q"}), @ORM\Index(name="fn_qqq", columns={"qqq"})})
 * @ORM\Entity(repositoryClass="App\Repository\ExamenRepository")
 */
class Examen
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
     * @ORM\Column(name="titre", type="string", length=255, nullable=false)
     * * @Assert\NotBlank(message="le titre ne doit pas étre vide")
     *  @Assert\Length(
     *      min = 5,
     *      max = 100,
     *      minMessage = "Le Titre correct doit comporter au minimum {{ limit }} characters",
     *      maxMessage = "Le Titre correct ne doit pas depasser {{ limit }} characters",
     *      allowEmptyString = false
     *     )
     */
    private $titre;
////////////////////////////////////////////////////////////////
    /**
     * @var \DateTime|null
     * @Assert\GreaterThan("today")
     * @ORM\Column(name="date", type="date", nullable=false)
     */
    private $date;
    /**
     * Examen constructor.
     */
    public function __construct()
    {
        $this->date= new \DateTime();
    }

    /**
     * @return mixed
     */
    public function getDate()
    {

        return $this->date;
    }

    /**
     * @param mixed $date
     */
    public function setDate($date): void
    {
        $this->date = $date;
        $day   = $date->format('d'); // Format the current date, take the current day (01 to 31)
        $month = $date->format('m'); // Same with the month
        $year  = $date->format('Y'); // Same with the year

        $date = $day.'-'.$month.'-'.$year; // Return a string and not an object

    }
    /////////////////////////////////////////
    /**
     * @var string
     *
     * @ORM\Column(name="niveau", type="string", length=255, nullable=false)
     * * @Assert\NotBlank
     */
    private $niveau;

    /**
     * @var int|null
     *
     * @ORM\Column(name="prix", type="integer", nullable=true)
     * @Assert\NotBlank(message="le champ prix ne doit pas étre vide")
     * @Assert\GreaterThan (
     *      value = 0,
     *      message="le prix doit etre superieur à zéro"
     * )
     */
    private $prix;

    /**
     * @var string|null
     *
     * @ORM\Column(name="support", type="string", length=255, nullable=true)
     */
    private $support;

    /**
     * @var \Question
     *
     * @ORM\ManyToOne(targetEntity="Question")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="q", referencedColumnName="id")
     * })
     */
    private $q;

    /**
     * @var \Question
     *
     * @ORM\ManyToOne(targetEntity="Question")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="qq", referencedColumnName="id")
     * })
     */
    private $qq;

    /**
     * @var \Question
     *
     * @ORM\ManyToOne(targetEntity="Question")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="qqq", referencedColumnName="id")
     * })
     */
    private $qqq;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): self
    {
        $this->titre = $titre;

        return $this;
    }



    public function getNiveau(): ?string
    {
        return $this->niveau;
    }

    public function setNiveau(string $niveau): self
    {
        $this->niveau = $niveau;

        return $this;
    }

    public function getPrix(): ?int
    {
        return $this->prix;
    }

    public function setPrix(?int $prix): self
    {
        $this->prix = $prix;

        return $this;
    }

    public function getSupport(): ?string
    {
        return $this->support;
    }

    public function setSupport(?string $support): self
    {
        $this->support = $support;

        return $this;
    }

    public function getQ(): ?Question
    {
        return $this->q;
    }

    public function setQ(?Question $q): self
    {
        $this->q = $q;

        return $this;
    }

    public function getQq(): ?Question
    {
        return $this->qq;
    }

    public function setQq(?Question $qq): self
    {
        $this->qq = $qq;

        return $this;
    }

    public function getQqq(): ?Question
    {
        return $this->qqq;
    }

    public function setQqq(?Question $qqq): self
    {
        $this->qqq = $qqq;

        return $this;
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

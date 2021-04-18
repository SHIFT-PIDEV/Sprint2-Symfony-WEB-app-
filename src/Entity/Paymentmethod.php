<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Paymentmethod
 *
 * @ORM\Table(name="paymentmethod")
 * @ORM\Entity
 */
class Paymentmethod
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
     * @ORM\Column(name="nom", type="string", length=25, nullable=false)
     * @Assert\NotBlank(
     *     message = "Champ Vide!"
     * )
     */
    private $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="prenom", type="string", length=25, nullable=false)
     * @Assert\NotBlank(
     *     message = "Champ Vide!"
     * )
     */
    private $prenom;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255, nullable=false)
     * @Assert\NotBlank(message="Champ vide")
     * @Assert\Email(
     *     message = "email '{{ value }}' est non valide."
     * )
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="pays", type="string", length=25, nullable=false)
     * @Assert\NotEqualTo("NULL", message = "Choisi votre pays !")
     * )
     */
    private $pays;

    /**
     * @var int
     *
     * @ORM\Column(name="codepostal", type="integer", nullable=false)
     * @Assert\NotBlank(
     *     message = "Champ Vide!"
     * )
     * @Assert\GreaterThanOrEqual(
     *     value = 0,
     *     message= "Ce champ ne doit pas etre negative ! "
     * )
     * @Assert\Length(max=5)
     */
    private $codepostal;

    /**
     * @var int
     *
     * @ORM\Column(name="numcarte", type="integer", nullable=false)
     * @Assert\NotBlank(
     *     message = "Champ Vide!"
     * )
     * @Assert\GreaterThanOrEqual(
     *     value = 0,
     *     message= "Ce champ ne doit pas etre negative ! "
     * )
     * @Assert\CardScheme(
     *     schemes={"VISA"},
     *     message="Your credit card number is invalid."
     * )
     */
    private $numcarte;

    /**
     * @var int
     *
     * @ORM\Column(name="cvc", type="integer", nullable=false)
     * @Assert\NotBlank(
     *     message = "Champ Vide!"
     * )
     * @Assert\GreaterThanOrEqual(
     *     value = 0,
     *     message= "Ce champ ne doit pas etre negative ! "
     * )
     */
    private $cvc;

    /**
     * @var string
     *
     * @ORM\Column(name="datecarte", type="string", length=5, nullable=false)
     * @Assert\NotBlank(
     *     message = "Champ Vide!"
     * )
     */
    private $datecarte;

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

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPays(): ?string
    {
        return $this->pays;
    }

    public function setPays(string $pays): self
    {
        $this->pays = $pays;

        return $this;
    }

    public function getCodepostal(): ?int
    {
        return $this->codepostal;
    }

    public function setCodepostal(int $codepostal): self
    {
        $this->codepostal = $codepostal;

        return $this;
    }

    public function getNumcarte(): ?int
    {
        return $this->numcarte;
    }

    public function setNumcarte(int $numcarte): self
    {
        $this->numcarte = $numcarte;

        return $this;
    }

    public function getCvc(): ?int
    {
        return $this->cvc;
    }

    public function setCvc(int $cvc): self
    {
        $this->cvc = $cvc;

        return $this;
    }

    public function getDatecarte(): ?string
    {
        return $this->datecarte;
    }

    public function setDatecarte(string $datecarte): self
    {
        $this->datecarte = $datecarte;

        return $this;
    }


}

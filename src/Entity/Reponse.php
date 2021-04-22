<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Reponse
 *
 * @ORM\Table(name="reponse", indexes={@ORM\Index(name="fn_repC", columns={"reponseC"})})
 * @ORM\Entity
 */
class Reponse
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
     * @ORM\Column(name="reponse", type="string", length=255, nullable=false)
     * * @Assert\NotBlank(message="le champs reponse fausse de doit pas etre vide ")
     *  @Assert\Length(
     *      min = 5,
     *      max = 100,
     *      minMessage = "La reponse fausse doit comporter au minimum {{ limit }} characters",
     *      maxMessage = "La reponse fausse ne doit pas depasser {{ limit }} characters",
     *      allowEmptyString = false
     *     )
     */
    private $reponse;

    /**
     * @var \Question
     *
     * @ORM\ManyToOne(targetEntity="Question")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="reponseC", referencedColumnName="id")
     * })
     */
    private $reponsec;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getReponse(): ?string
    {
        return $this->reponse;
    }

    public function setReponse(string $reponse): self
    {
        $this->reponse = $reponse;

        return $this;
    }

    public function getReponsec(): ?Question
    {
        return $this->reponsec;
    }

    public function setReponsec(?Question $reponsec): self
    {
        $this->reponsec = $reponsec;

        return $this;
    }


}

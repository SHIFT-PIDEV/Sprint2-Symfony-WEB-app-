<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Question
 *
 * @ORM\Table(name="question")
 * @ORM\Entity
 */
class Question
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
     * @ORM\Column(name="question", type="string", length=255, nullable=false)
     * @Assert\NotBlank(message="le champs Question de doit pas etre vide ")
     *  @Assert\Length(
     *      min = 5,
     *      max = 100,
     *      minMessage = "La Question correct doit comporter au minimum {{ limit }} characters",
     *      maxMessage = "La question correct ne doit pas depasser {{ limit }} characters",
     *      allowEmptyString = false
     *     )
     */
    private $question;

    /**
     * @var string
     *
     * @ORM\Column(name="reponseC", type="string", length=255, nullable=false)
     * * @Assert\NotBlank(message="le champs Reponse Correct de doit pas etre vide ")
     *  @Assert\Length(
     *      min = 5,
     *      max = 100,
     *      minMessage = "La reponse correct doit comporter au minimum {{ limit }} characters",
     *      maxMessage = "La reponse correct ne doit pas depasser {{ limit }} characters",
     *      allowEmptyString = false
     *     )
     */
    private $reponsec;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuestion(): ?string
    {
        return $this->question;
    }

    public function setQuestion(string $question): self
    {
        $this->question = $question;

        return $this;
    }

    public function getReponsec(): ?string
    {
        return $this->reponsec;
    }

    public function setReponsec(string $reponsec): self
    {
        $this->reponsec = $reponsec;

        return $this;
    }


}

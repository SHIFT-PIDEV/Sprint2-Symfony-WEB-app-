<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use phpDocumentor\Reflection\Types\Integer;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Form\Extension\Core\Type\FileType;

/**
 * Demande
 *
 * @ORM\Table(name="demande")
 * @ORM\Entity(repositoryClass="App\Repository\DemandeRepository")
 */
class Demande
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="objet", type="string", length=225, nullable=false)
     *@Assert\NotBlank(message="objet is required")
     */

    private $objet;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=225, nullable=false)
     *@Assert\NotBlank(message="Description is required")
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="cv", type="string", length=225, nullable=false)
     * @Assert\File(mimeTypes={ "application/pdf" })
     */
    private $cv;

    /**
     * @ORM\Column(type="integer", nullable=true, options={"default" : 0})
     */
    private $status=0;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getObjet(): ?string
    {
        return $this->objet;
    }

    public function setObjet(string $objet): self
    {
        $this->objet = $objet;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getCv(): ?string
    {
        return $this->cv;
    }

    public function setCv( $cv): self
    {
        $this->cv = $cv;

        return $this;
    }

    public function getStatus(): ?int
    {
        return $this->status;
    }

    public function setStatus(?int $status): self
    {
        $this->status = $status;

        return $this;
    }


}

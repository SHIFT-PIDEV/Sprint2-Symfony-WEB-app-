<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use App\Repository\CouponRepository;

/**
 * @ORM\Entity(repositoryClass=CouponRepository::class)
 */
class Coupon
{
    /**
     * @var int
     *
     * @ORM\Column(name="idc", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idc;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=255, nullable=false)
     * @Assert\NotBlank(
     *     message = "Champ vide"
     * )
     */
    private $type;

    /**
     * @var string
     *
     * @ORM\Column(name="val", type="string", length=255, nullable=false)
     * @Assert\NotBlank(
     *     message = "Champ vide"
     * )
     */
    private $val;

    /**
     * @var int|null
     *
     * @ORM\Column(name="score", type="integer", nullable=true)
     *  @Assert\NotBlank(
     *     message = "Champ vide"
     * )
     *  @Assert\GreaterThanOrEqual(
     *     value = 0,
     *     message= "Le score est negative "
     * )
     */
    private $score;

    public function getIdc(): ?int
    {
        return $this->idc;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getVal(): ?string
    {
        return $this->val;
    }

    public function setVal(string $val): self
    {
        $this->val = $val;

        return $this;
    }

    public function getScore(): ?int
    {
        return $this->score;
    }

    public function setScore(?int $score): self
    {
        $this->score = $score;

        return $this;
    }


}

<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Examen
 *
 * @ORM\Table(name="examen", indexes={@ORM\Index(name="fn_qqq", columns={"qqq"}), @ORM\Index(name="fn_q", columns={"q"}), @ORM\Index(name="fn_qq", columns={"qq"})})
 * @ORM\Entity
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
     */
    private $titre;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="date", type="date", nullable=true)
     */
    private $date;

    /**
     * @var string
     *
     * @ORM\Column(name="niveau", type="string", length=255, nullable=false)
     */
    private $niveau;

    /**
     * @var int|null
     *
     * @ORM\Column(name="prix", type="integer", nullable=true)
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


}

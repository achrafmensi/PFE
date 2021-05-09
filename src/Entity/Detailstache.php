<?php

namespace App\Entity;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;


/**
 * @ORM\Entity(repositoryClass="App\Repository\DetailstacheRepository")
 *  @UniqueEntity("tache",message = "Ce Tache a deja un detail Tache")
 */
class Detailstache
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\tache",inversedBy="detailstache")
     * @Assert\NotNull()
     */
    private $tache;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $description;

    /**
     * @ORM\Column(type="date")
     */
    private $datesaisie;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $status;

    /**
     * @ORM\Column(type="float")
     */
    private $Frais;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="saisiepar")
     * @ORM\JoinColumn(nullable=false)
     */
    private $saisiepar;


    public function getId(): ?int
    {
        return $this->id;
    }
    public function __toString() {
        return $this->Tache;
    }


    public function getTache(): ?tache
    {
        return $this->tache;
    }

    public function setTache(?tache $tache): self
    {
        $this->tache = $tache;

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

    public function getDatesaisie(): ?\DateTimeInterface
    {
        return $this->datesaisie;
    }

    public function setDatesaisie(\DateTimeInterface $datesaisie): self
    {
        $this->datesaisie = $datesaisie;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getFrais(): ?float
    {
        return $this->Frais;
    }

    public function setFrais(float $Frais): self
    {
        $this->Frais = $Frais;

        return $this;
    }

    public function getSaisiepar(): ?User
    {
        return $this->saisiepar;
    }

    public function setSaisiepar(?User $saisiepar): self
    {
        $this->saisiepar = $saisiepar;

        return $this;
    }
}

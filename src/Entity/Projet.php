<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;


/**
 * @ORM\Entity(repositoryClass="App\Repository\ProjetRepository")
 *  @UniqueEntity("nom")

 */
class Projet
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank
     */
    private $description;

    /**
     * @ORM\Column(type="date")
     */
    private $datedebut;

    /**
     * @ORM\Column(type="date")
     * @Assert\GreaterThan(propertyPath="datedebut")
     */
    private $datefin;

    /**
     * @ORM\Column(type="string")
     */
    private $status;

    /**
     * @ORM\Column(type="float")
     */
    private $budget;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="chef")
     * @ORM\JoinColumn(nullable=false)
     */
    private $chefdeprojet;

    /**
     * @ORM\Column(type="string")
     */
    private $typedeprojet;

    /**
     * @ORM\Column(type="string")
     */
    private $nature;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\user", inversedBy="client")
     * @ORM\JoinColumn(nullable=true)

     */
    private $client;

    /**
     * @ORM\Column(type="float")
     * @Assert\LessThan(100)
     */
    private $avencement;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Tache", mappedBy="projet", cascade={"persist","remove"})
     */
    private $taches;



    public function __construct()
    {
        $this->taches = new ArrayCollection();
    }

    public function __toString() {
        return $this->nom;
    }

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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getDatedebut(): ?\DateTimeInterface
    {
        return $this->datedebut;
    }

    public function setDatedebut(\DateTimeInterface $datedebut): self
    {
        $this->datedebut = $datedebut;

        return $this;
    }

    public function getDatefin(): ?\DateTimeInterface
    {
        return $this->datefin;
    }

    public function setDatefin(\DateTimeInterface $datefin): self
    {
        $this->datefin = $datefin;

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

    public function getBudget(): ?float
    {
        return $this->budget;
    }

    public function setBudget(float $budget): self
    {
        $this->budget = $budget;

        return $this;
    }

    public function getChefdeprojet(): ?User
    {
        return $this->chefdeprojet;
    }

    public function setChefdeprojet(?user $chefdeprojet): self
    {
        $this->chefdeprojet = $chefdeprojet;

        return $this;
    }

    public function getTypedeprojet(): ?string
    {
        return $this->typedeprojet;
    }

    public function setTypedeprojet(string $typedeprojet): self
    {
        $this->typedeprojet = $typedeprojet;

        return $this;
    }

    public function getNature(): ?string
    {
        return $this->nature;
    }

    public function setNature(string $nature): self
    {
        $this->nature = $nature;

        return $this;
    }

    public function getClient(): ?user
    {
        return $this->client;
    }

    public function setClient(?user $client): self
    {
        $this->client = $client;

        return $this;
    }

    public function getAvencement(): ?float
    {
        return $this->avencement;
    }

    public function setAvencement(float $avencement): self
    {
        $this->avencement = $avencement;

        return $this;
    }

    /**
     * @return Collection|Tache[]
     */
    public function getTaches(): Collection
    {
        return $this->taches;
    }

    public function addTach(Tache $tach): self
    {
        if (!$this->taches->contains($tach)) {
            $this->taches[] = $tach;
            $tach->setProjet($this);
        }

        return $this;
    }

    public function removeTach(Tache $tach): self
    {
        if ($this->taches->contains($tach)) {
            $this->taches->removeElement($tach);
            // set the owning side to null (unless already changed)
            if ($tach->getProjet() === $this) {
                $tach->setProjet(null);
            }
        }

        return $this;
    }

   
}

<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TacheRepository")
 */
class Tache
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
     * @ORM\ManyToOne(targetEntity="App\Entity\projet", inversedBy="taches")
     *  @Assert\NotBlank
     */
    private $projet;

    /**
     * @ORM\Column(type="date")
     * @Assert\GreaterThan(propertyPath="projet.datedebut", message = "Date fin prevue doit etre supérieur a la date debut du projet")

     */
    private $datedebut;

    /**
     * @ORM\Column(type="date")
     * @Assert\GreaterThan(propertyPath="datedebut",message = "Date fin prevue doit etre supérieur a la date debut")
     * 
     */
    private $datefinprevue;

    /**
     * @ORM\Column(type="date", nullable=true)
     * @Assert\GreaterThan(propertyPath="datedebut",message = "Date fin reel doit etre supérieur a la date debut")
     */
    private $datefinreel;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\user", inversedBy="tacheconsultant")
     * @Assert\NotNull
     */
    private $consultant;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nature;

    // /**
    //  * @ORM\ManyToOne(targetEntity="App\Entity\user", inversedBy="tacheschefdeprojet")
    //  * @Assert\NotNull
    //  */
    // private $chefdeprojet;

    // /**
    //  * @ORM\ManyToOne(targetEntity="App\Entity\user", inversedBy="tachesclient")
    //  * 
    //  */
    // private $client;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $description;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Detailstache",mappedBy="tache",cascade={"persist","remove"})
     */
    public $detailstache;

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

    public function getProjet(): ?projet
    {
        return $this->projet;
    }

    public function setProjet(?projet $projet): self
    {
        $this->projet = $projet;

        return $this;
    }

    public function getDetailstache (): ?detailstache 
    {
        return $this->detailstache ;
    }

    public function setDetailstache (?detailstache  $detailstache ): self
    {
        $this->detailstache  = $detailstache ;

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

    public function getDatefinprevue(): ?\DateTimeInterface
    {
        return $this->datefinprevue;
    }

    public function setDatefinprevue(\DateTimeInterface $datefinprevue): self
    {
        $this->datefinprevue = $datefinprevue;

        return $this;
    }

    public function getDatefinreel(): ?\DateTimeInterface
    {
        return $this->datefinreel;
    }

    public function setDatefinreel(?\DateTimeInterface $datefinreel): self
    {
        $this->datefinreel = $datefinreel;

        return $this;
    }

    public function getConsultant(): ?user
    {
        return $this->consultant;
    }

    public function setConsultant(?user $consultant): self
    {
        $this->consultant = $consultant;

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

    public function getChefdeprojet(): ?user
    {
        return $this->chefdeprojet;
    }

    public function setChefdeprojet(?user $chefdeprojet): self
    {
        $this->chefdeprojet = $chefdeprojet;

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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }
    public function __toString() {
        return $this->nom;
    }
}

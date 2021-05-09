<?php
// src/Entity/User.php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;


/**
 * @ORM\Entity
 * @ORM\Table(name="fos_user")
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")

 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

     /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Group")
     * @ORM\JoinTable(name="fos_user_user_group",
     *      joinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="id" , onDelete="cascade")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="group_id", referencedColumnName="id")}
     * )
     */
    protected $groups;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Projet", mappedBy="chefdeprojet")
     */
    private $chef;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Projet", mappedBy="client")
     */
    private $client;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Tache", mappedBy="consultant")
     */
    private $tacheconsultant;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Tache", mappedBy="chefdeprojet")
     */
    private $tacheschefdeprojet;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Tache", mappedBy="client")
     */
    private $tachesclient;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\DetailsTache", mappedBy="saisiepar")
     */
    private $saisiepar;


    public function __construct()
    {
        parent::__construct();
        $this->chef = new ArrayCollection();
        $this->client = new ArrayCollection();
        $this->tacheconsultant = new ArrayCollection();
        $this->tacheschefdeprojet = new ArrayCollection();
        $this->tachesclient = new ArrayCollection();
        $this->saisiepar = new ArrayCollection();
        // your own logic
    }

    /**
     * @return Collection|Projet[]
     */
    public function getChef(): Collection
    {
        return $this->chef;
    }

    public function addChef(Projet $chef): self
    {
        if (!$this->chef->contains($chef)) {
            $this->chef[] = $chef;
            $chef->setChefdeprojet($this);
        }

        return $this;
    }

    public function removeChef(Projet $chef): self
    {
        if ($this->chef->contains($chef)) {
            $this->chef->removeElement($chef);
            // set the owning side to null (unless already changed)
            if ($chef->getChefdeprojet() === $this) {
                $chef->setChefdeprojet(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Projet[]
     */
    public function getClient(): Collection
    {
        return $this->client;
    }

    public function addClient(Projet $client): self
    {
        if (!$this->client->contains($client)) {
            $this->client[] = $client;
            $client->setClient($this);
        }

        return $this;
    }

    public function removeClient(Projet $client): self
    {
        if ($this->client->contains($client)) {
            $this->client->removeElement($client);
            // set the owning side to null (unless already changed)
            if ($client->getClient() === $this) {
                $client->setClient(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Tache[]
     */
    public function getTacheconsultant(): Collection
    {
        return $this->tacheconsultant;
    }

    public function addTacheconsultant(Tache $tacheconsultant): self
    {
        if (!$this->tacheconsultant->contains($tacheconsultant)) {
            $this->tacheconsultant[] = $tacheconsultant;
            $tacheconsultant->setConsultant($this);
        }

        return $this;
    }

    public function removeTacheconsultant(Tache $tacheconsultant): self
    {
        if ($this->tacheconsultant->contains($tacheconsultant)) {
            $this->tacheconsultant->removeElement($tacheconsultant);
            // set the owning side to null (unless already changed)
            if ($tacheconsultant->getConsultant() === $this) {
                $tacheconsultant->setConsultant(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Tache[]
     */
    public function getTacheschefdeprojet(): Collection
    {
        return $this->tacheschefdeprojet;
    }

    public function addTacheschefdeprojet(Tache $tacheschefdeprojet): self
    {
        if (!$this->tacheschefdeprojet->contains($tacheschefdeprojet)) {
            $this->tacheschefdeprojet[] = $tacheschefdeprojet;
            $tacheschefdeprojet->setChefdeprojet($this);
        }

        return $this;
    }

    public function removeTacheschefdeprojet(Tache $tacheschefdeprojet): self
    {
        if ($this->tacheschefdeprojet->contains($tacheschefdeprojet)) {
            $this->tacheschefdeprojet->removeElement($tacheschefdeprojet);
            // set the owning side to null (unless already changed)
            if ($tacheschefdeprojet->getChefdeprojet() === $this) {
                $tacheschefdeprojet->setChefdeprojet(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Tache[]
     */
    public function getTachesclient(): Collection
    {
        return $this->tachesclient;
    }

    public function addTachesclient(Tache $tachesclient): self
    {
        if (!$this->tachesclient->contains($tachesclient)) {
            $this->tachesclient[] = $tachesclient;
            $tachesclient->setClient($this);
        }

        return $this;
    }

    public function removeTachesclient(Tache $tachesclient): self
    {
        if ($this->tachesclient->contains($tachesclient)) {
            $this->tachesclient->removeElement($tachesclient);
            // set the owning side to null (unless already changed)
            if ($tachesclient->getClient() === $this) {
                $tachesclient->setClient(null);
            }
        }

        return $this;
    }
    public function findAllroles($roles): array
{
    
    $conn = $this->getEntityManager()->getConnection();

    $sql = '
        SELECT * FROM fos_user p
        WHERE p.roles LIKE :roles
        ';
    $stmt = $conn->prepare($sql);
    $stmt->execute(['roles' => $roles]);

    // returns an array of arrays (i.e. a raw data set)
    return $stmt->fetchAll();
}

    /**
     * @return Collection|DetailsTache[]
     */
    public function getSaisiepar(): Collection
    {
        return $this->saisiepar;
    }

    public function addSaisiepar(DetailsTache $saisiepar): self
    {
        if (!$this->saisiepar->contains($saisiepar)) {
            $this->saisiepar[] = $saisiepar;
            $saisiepar->setSaisiepar($this);
        }

        return $this;
    }

    public function removeSaisiepar(DetailsTache $saisiepar): self
    {
        if ($this->saisiepar->contains($saisiepar)) {
            $this->saisiepar->removeElement($saisiepar);
            // set the owning side to null (unless already changed)
            if ($saisiepar->getSaisiepar() === $this) {
                $saisiepar->setSaisiepar(null);
            }
        }

        return $this;
    }

    
}

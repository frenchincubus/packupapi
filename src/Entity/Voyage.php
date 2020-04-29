<?php

namespace App\Entity;

use DateTime;
use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Core\Annotation\ApiSubresource;

/**
 * @ApiResource(attributes={
 *      "normalization_context"={"groups"={"voyage"}}
 * })
 * @ORM\Entity(repositoryClass="App\Repository\VoyageRepository")
 * @ORM\HasLifecycleCallbacks()
 *
 */
class Voyage
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"voyage", "user"})
     */
    private $name;

    /**
     * @ORM\Column(type="text", nullable=true)
     * @Groups({"voyage", "user"})
     */
    private $description;

    /**
     * @ORM\Column(type="datetime")
     * @Groups({"voyage", "user"})
     */
    private $dateDebut;

    /**
     * @ORM\Column(type="datetime")
     * @Groups({"voyage", "user"})
     */
    private $dateFin;

    /**
     * @ORM\Column(type="float", nullable=true)
     * @Groups({"voyage", "user"})
     */
    private $budget;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"voyage", "user"})
     */
    private $photo;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @Groups({"voyage", "user"})
     */
    private $datePublication;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @Groups({"voyage", "user"})
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @Groups({"voyage", "user"})
     */
    private $updatedAt;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Groups({"voyage", "user"})
     */
    private $priorite;

    /**
     * @ORM\Column(type="boolean")
     * @Groups({"voyage", "user"})
     */
    private $isDeleted;

    /**
     * @ORM\Column(type="boolean")
     * @Groups({"voyage", "user"})
     */
    private $isPublic;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="voyages")
     * @ORM\JoinColumn(nullable=false)
     * @ApiSubresource
     * @Groups("voyage")
     */
    private $userId;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Commentaires", mappedBy="voyageId", orphanRemoval=true)
     * @Groups("voyage")
     */
    private $commentaires;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\User", mappedBy="voyagesSuivis")
     * @Groups("voyage")
     */
    private $users;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Etape", mappedBy="voyageId", orphanRemoval=true)
     * @Groups("voyage")
     */
    private $etapes;

    /**
     * @ORM\Column(type="smallint", nullable=true)
     * @Groups("voyage")
     */
    private $nbPersonnes;

    public function __construct()
    {
        $this->createdAt = new DateTime();
        $this->commentaires = new ArrayCollection();
        $this->users = new ArrayCollection();
        $this->etapes = new ArrayCollection();
        $this->setIsDeleted(false);
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getDateDebut(): ?DateTimeInterface
    {
        return $this->dateDebut;
    }

    public function setDateDebut(DateTimeInterface $dateDebut): self
    {
        $this->dateDebut = $dateDebut;

        return $this;
    }

    public function getDateFin(): ?DateTimeInterface
    {
        return $this->dateFin;
    }

    public function setDateFin(DateTimeInterface $dateFin): self
    {
        $this->dateFin = $dateFin;

        return $this;
    }

    public function getBudget(): ?float
    {
        return $this->budget;
    }

    public function setBudget(?float $budget): self
    {
        $this->budget = $budget;

        return $this;
    }

    public function getPhoto(): ?string
    {
        return $this->photo;
    }

    public function setPhoto(?string $photo): self
    {
        $this->photo = $photo;

        return $this;
    }

    public function getDatePublication(): ?DateTimeInterface
    {
        return $this->datePublication;
    }

    public function setDatePublication(?DateTimeInterface $datePublication): self
    {
        $this->datePublication = $datePublication;

        return $this;
    }

    public function getPriorite(): ?int
    {
        return $this->priorite;
    }

    public function setPriorite(?int $priorite): self
    {
        $this->priorite = $priorite;

        return $this;
    }

    public function getIsDeleted(): ?bool
    {
        return $this->isDeleted;
    }

    public function setIsDeleted(bool $isDeleted): self
    {
        $this->isDeleted = $isDeleted;

        return $this;
    }

    public function getIsPublic(): ?bool
    {
        return $this->isPublic;
    }

    public function setIsPublic(bool $isPublic): self
    {
        $this->isPublic = $isPublic;

        return $this;
    }

    public function getUserId(): ?User
    {
        return $this->userId;
    }

    public function setUserId(?User $userId): self
    {
        $this->userId = $userId;

        return $this;
    }

    /**
     * @return Collection|Commentaires[]
     */
    public function getCommentaires(): Collection
    {
        return $this->commentaires;
    }

    /**
     * @param Commentaires $commentaire
     * @return $this
     */
    public function addCommentaire(Commentaires $commentaire): self
    {
        if (!$this->commentaires->contains($commentaire)) {
            $this->commentaires[] = $commentaire;
            $commentaire->setVoyageId($this);
        }

        return $this;
    }

    /**
     * @param Commentaires $commentaire
     * @return $this
     */
    public function removeCommentaire(Commentaires $commentaire): self
    {
        if ($this->commentaires->contains($commentaire)) {
            $this->commentaires->removeElement($commentaire);
            // set the owning side to null (unless already changed)
            if ($commentaire->getVoyageId() === $this) {
                $commentaire->setVoyageId(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    /**
     * @param User $user
     * @return $this
     */
    public function addUser(User $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users[] = $user;
            $user->addVoyagesSuivi($this);
        }

        return $this;
    }

    /**
     * @param User $user
     * @return $this
     */
    public function removeUser(User $user): self
    {
        if ($this->users->contains($user)) {
            $this->users->removeElement($user);
            $user->removeVoyagesSuivi($this);
        }

        return $this;
    }

    /**
     * @return Collection|Etape[]
     */
    public function getEtapes(): Collection
    {
        return $this->etapes;
    }

    /**
     * @param Etape $etape
     * @return $this
     */
    public function addEtape(Etape $etape): self
    {
        if (!$this->etapes->contains($etape)) {
            $this->etapes[] = $etape;
            $etape->setVoyageId($this);
        }

        return $this;
    }

    /**
     * @param Etape $etape
     * @return $this
     */
    public function removeEtape(Etape $etape): self
    {
        if ($this->etapes->contains($etape)) {
            $this->etapes->removeElement($etape);
            // set the owning side to null (unless already changed)
            if ($etape->getVoyageId() === $this) {
                $etape->setVoyageId(null);
            }
        }

        return $this;
    }

    /**
     * @return int|null
     */
    public function getNbPersonnes(): ?int
    {
        return $this->nbPersonnes;
    }

    /**
     * @param int|null $nbPersonnes
     * @return $this
     */
    public function setNbPersonnes(?int $nbPersonnes): self
    {
        $this->nbPersonnes = $nbPersonnes;

        return $this;
    }

    /**
     * @return string|null
     */
    public function __toString()
    {
        return $this->getName();
    }

    /**
     * @return mixed
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * @param mixed $updatedAt
     * @return Voyage
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;
        return $this;
    }

    /**
     * @ORM\PreUpdate()
     */
    public function DateUpdate()
    {
        $this->setUpdatedAt(new DateTime());
    }

    /**
     * @return mixed
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @param mixed $createdAt
     * @return Voyage
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
        return $this;
    }


}

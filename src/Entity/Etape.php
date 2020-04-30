<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use DateTime;
use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\MaxDepth;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass="App\Repository\EtapeRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Etape
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"voyage:read", "voyage:write"})
     * @MaxDepth(1)
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"voyage:read", "voyage:write"})
     * @MaxDepth(1)
     */
    private $name;

    /**
     * @ORM\Column(type="text", nullable=true)
     * @Groups({"voyage:read", "voyage:write"})
     * @MaxDepth(1)
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"voyage:read", "voyage:write"})
     * @MaxDepth(1)
     */
    private $pays;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"voyage:read", "voyage:write"})
     * @MaxDepth(1)
     */
    private $ville;

    /**
     * @ORM\Column(type="array")
     * @Groups({"voyage:read", "voyage:write"})
     * @MaxDepth(1)
     */
    private $coordinates = [];

    /**
     * @ORM\Column(type="datetime")
     * @Groups({"voyage:read", "voyage:write"})
     * @MaxDepth(1)
     */
    private $dateDebut;

    /**
     * @ORM\Column(type="datetime")
     * @Groups({"voyage:read", "voyage:write"})
     * @MaxDepth(1)
     */
    private $dateFin;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"voyage:read", "voyage:write"})
     * @MaxDepth(1)
     */
    private $photo;

    /**
     * @ORM\Column(type="float", nullable=true)
     * @Groups({"voyage:read", "voyage:write"})
     * @MaxDepth(1)
     */
    private $budget;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Voyage", inversedBy="etapes")
     * @ORM\JoinColumn(nullable=false)
     * @Groups("voyage:read")
     * @MaxDepth(1)
     */
    private $voyageId;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Activite", mappedBy="etapeId", cascade={"persist", "remove"}, orphanRemoval=true)
     * @Groups({"voyage:write", "voyage:read"})
     * @MaxDepth(1)
     */
    private $activites;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $updatedAt;



    public function __construct()
    {
        $this->activites = new ArrayCollection();
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

    public function getPays(): ?string
    {
        return $this->pays;
    }

    public function setPays(string $pays): self
    {
        $this->pays = $pays;

        return $this;
    }

    public function getVille(): ?string
    {
        return $this->ville;
    }

    public function setVille(?string $ville): self
    {
        $this->ville = $ville;

        return $this;
    }

    public function getCoordinates(): ?array
    {
        return $this->coordinates;
    }

    public function setCoordinates(array $coordinates): self
    {
        $this->coordinates = $coordinates;

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

    public function getPhoto(): ?string
    {
        return $this->photo;
    }

    public function setPhoto(?string $photo): self
    {
        $this->photo = $photo;

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

    public function getVoyageId(): ?Voyage
    {
        return $this->voyageId;
    }

    public function setVoyageId(?Voyage $voyageId): self
    {
        $this->voyageId = $voyageId;

        return $this;
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
     * @return Etape
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;
        return $this;
    }



    /**
     * @return Collection|Activite[]
     */
    public function getActivites(): Collection
    {
        return $this->activites;
    }

    public function addActivite(Activite $activite): self
    {
        if (!$this->activites->contains($activite)) {
            $this->activites[] = $activite;
            $activite->setEtapeId($this);
        }

        return $this;
    }

    public function removeActivite(Activite $activite): self
    {
        if ($this->activites->contains($activite)) {
            $this->activites->removeElement($activite);
            // set the owning side to null (unless already changed)
            if ($activite->getEtapeId() === $this) {
                $activite->setEtapeId(null);
            }
        }

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
     * @ORM\PreUpdate()
     */
    public function DateUpdate()
    {
        $this->setUpdatedAt(new DateTime());
    }
}

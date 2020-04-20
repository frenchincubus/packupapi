<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass="App\Repository\EtapeRepository")
 */
class Etape
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups("voyage")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups("voyage")
     */
    private $name;

    /**
     * @ORM\Column(type="text", nullable=true)
     * @Groups("voyage")
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups("voyage")
     */
    private $pays;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups("voyage")
     */
    private $ville;

    /**
     * @ORM\Column(type="array")
     * @Groups("voyage")
     */
    private $coordinates = [];

    /**
     * @ORM\Column(type="datetime")
     * @Groups("voyage")
     */
    private $dateDebut;

    /**
     * @ORM\Column(type="datetime")
     * @Groups("voyage")
     */
    private $dateFin;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups("voyage")
     */
    private $photo;

    /**
     * @ORM\Column(type="float", nullable=true)
     * @Groups("voyage")
     */
    private $budget;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Voyage", inversedBy="etapes")
     * @ORM\JoinColumn(nullable=false)
     */
    private $voyageId;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Activite", mappedBy="etapeId", orphanRemoval=true)
     * @Groups("voyage")
     */
    private $activites;

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

    public function getDateDebut(): ?\DateTimeInterface
    {
        return $this->dateDebut;
    }

    public function setDateDebut(\DateTimeInterface $dateDebut): self
    {
        $this->dateDebut = $dateDebut;

        return $this;
    }

    public function getDateFin(): ?\DateTimeInterface
    {
        return $this->dateFin;
    }

    public function setDateFin(\DateTimeInterface $dateFin): self
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
}

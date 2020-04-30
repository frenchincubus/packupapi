<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass="App\Repository\ActiviteRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Activite
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"voyage:read", "voyage:write"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"voyage:read", "voyage:write"})
     */
    private $nom;

    /**
     * @ORM\Column(type="text", nullable=true)
     * @Groups({"voyage:read", "voyage:write"})
     */
    private $description;

    /**
     * @ORM\Column(type="array")
     * @Groups({"voyage:read", "voyage:write"})
     */
    private $coordinates = [];

    /**
     * @ORM\Column(type="datetime")
     * @Groups({"voyage:read", "voyage:write"})
     */
    private $dateDebut;

    /**
     * @ORM\Column(type="datetime")
     * @Groups({"voyage:read", "voyage:write"})
     */
    private $dateFin;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"voyage:read", "voyage:write"})
     */
    private $typeTransport;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Etape", inversedBy="activites")
     * @ORM\JoinColumn(nullable=false)
     * @Groups("voyage:read")
     */
    private $etapeId;

    /**
     * @ORM\Column(type="array", nullable=true)
     * @Groups({"voyage:read", "voyage:write"})
     */
    private $photo = [];

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $updatedAt;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"voyage:read", "voyage:write"})
     */
    private $idFoursquare;

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

    public function setDescription(?string $description): self
    {
        $this->description = $description;

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

    public function getEtapeId(): ?Etape
    {
        return $this->etapeId;
    }

    public function setEtapeId(?Etape $etapeId): self
    {
        $this->etapeId = $etapeId;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getTypeTransport()
    {
        return $this->typeTransport;
    }

    /**
     * @param mixed $typeTransport
     * @return Activite
     */
    public function setTypeTransport($typeTransport)
    {
        $this->typeTransport = $typeTransport;
        return $this;
    }

    public function getPhoto(): ?array
    {
        return $this->photo;
    }

    public function setPhoto(?array $photo): self
    {
        $this->photo = $photo;

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
     * @return Activite
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;
        return $this;
    }

    /**
     * @return string|null
     */
    public function __toString()
    {
        return $this->getNom();
    }

    public function getIdFoursquare(): ?string
    {
        return $this->idFoursquare;
    }

    public function setIdFoursquare(?string $idFoursquare): self
    {
        $this->idFoursquare = $idFoursquare;

        return $this;
    }

    /**
     * @ORM\PreUpdate()
     */
    public function DateUpdate()
    {
        $this->setUpdatedAt(new DateTime());
    }

}

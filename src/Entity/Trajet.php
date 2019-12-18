<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass="App\Repository\TrajetRepository")
 */
class Trajet
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
    private $typeTransport;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $duree;

    /**
     * @ORM\Column(type="array")
     */
    private $coordinatesArrivee = [];

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Activite", inversedBy="trajets")
     * @ORM\JoinColumn(nullable=false)
     */
    private $activiteId;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTypeTransport(): ?string
    {
        return $this->typeTransport;
    }

    public function setTypeTransport(string $typeTransport): self
    {
        $this->typeTransport = $typeTransport;

        return $this;
    }

    public function getDuree(): ?string
    {
        return $this->duree;
    }

    public function setDuree(?string $duree): self
    {
        $this->duree = $duree;

        return $this;
    }

    public function getCoordinatesArrivee(): ?array
    {
        return $this->coordinatesArrivee;
    }

    public function setCoordinatesArrivee(array $coordinatesArrivee): self
    {
        $this->coordinatesArrivee = $coordinatesArrivee;

        return $this;
    }

    public function getActiviteId(): ?Activite
    {
        return $this->activiteId;
    }

    public function setActiviteId(?Activite $activiteId): self
    {
        $this->activiteId = $activiteId;

        return $this;
    }
}

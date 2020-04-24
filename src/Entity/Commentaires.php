<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ApiResource(attributes={
 *      "normalization_context"={"groups"={"commentaire"}}
 * })
 * @ORM\Entity(repositoryClass="App\Repository\CommentairesRepository")
 */
class Commentaires
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups("commentaire")
     */
    private $id;

    /**
     * @ORM\Column(type="text")
     * @Groups({"commentaire", "user", "voyage"})
     */
    private $message;

    /**
     * @ORM\Column(type="datetime")
     */
    private $datePublication;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="commentaires")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"user","commentaire", "voyage"})
     */
    private $userId;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Voyage", inversedBy="commentaires")
     * @ORM\JoinColumn(nullable=false)
     */
    private $voyageId;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function setMessage(string $message): self
    {
        $this->message = $message;

        return $this;
    }

    public function getDatePublication(): ?DateTimeInterface
    {
        return $this->datePublication;
    }

    public function setDatePublication(DateTimeInterface $datePublication): self
    {
        $this->datePublication = $datePublication;

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

    public function getVoyageId(): ?Voyage
    {
        return $this->voyageId;
    }

    public function setVoyageId(?Voyage $voyageId): self
    {
        $this->voyageId = $voyageId;

        return $this;
    }
}

<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use DateTime;
use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\MaxDepth;

/**
 * @ApiResource(attributes={
 *      "normalization_context"={"groups"={"user:read"}, "enable_max_depth"=true},
 *      "denormalization_context"={"groups"={"user:write"}}
 * })
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class User implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"voyage:read", "user:read", "user:write"})
     * @MaxDepth(1)
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     * @Groups({"user:read", "user:write"})
     * @MaxDepth(1)
     */
    private $email;

    /**
     * @ORM\Column(type="json")
     * @MaxDepth(1)
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     * @Groups({"user:read", "user:write"})
     * @MaxDepth(1)
     */
    private $password;

    /**
     * @ORM\Column(type="datetime")
     * @MaxDepth(1)
     */
    private $dateCreation;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $lastLogin;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @Groups("user")
     */
    private $updatedAt;

    /**
     * @Groups("user")
     * @var Image|null
     * @ORM\OneToOne(targetEntity="App\Entity\Image")
     * @ORM\JoinColumn(nullable=true, referencedColumnName="id")
     * @Groups({"user:read", "user:write", "voyage:read"})
     * @MaxDepth(1)
     */
    private $photo;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Voyage", mappedBy="userId", orphanRemoval=true)
     * @Groups({"user:read", "user:write"})
     * @MaxDepth(1)
     */
    private $voyages;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Commentaires", mappedBy="userId", orphanRemoval=true)
     * @MaxDepth(1)
     */
    private $commentaires;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\User", inversedBy="users")
     * @Groups({"user:read", "user:write"})
     * @MaxDepth(1)
     */
    private $amis;

     /**
     * @ORM\ManyToMany(targetEntity="App\Entity\User", mappedBy="amis")
     * @Groups({"user:read", "user:write"})
     * @MaxDepth(1)
     */
    private $users;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Voyage", inversedBy="users")
     * @Groups({"user:read", "user:write"})
     * @MaxDepth(1)
     */
    private $voyagesSuivis;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"voyage:read", "user:read", "user:write", "commentaire"})
     * @MaxDepth(2)
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"voyage:read", "user:read", "user:write", "commentaire"})
     * @MaxDepth(2)
     */
    private $prenom;

    /**
     * @ORM\Column(type="smallint", nullable=true)
     * @Groups({"user:read", "user:write"})
     * @MaxDepth(2)
     */
    private $age;

    public function __construct()
    {
        $this->voyages = new ArrayCollection();
        $this->commentaires = new ArrayCollection();
        $this->amis = new ArrayCollection();
        $this->users = new ArrayCollection();
        $this->voyagesSuivis = new ArrayCollection();
        $this->setLastLogin(new DateTime());
        $this->setDateCreation(new DateTime());
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getDateCreation(): ?DateTimeInterface
    {
        return $this->dateCreation;
    }

    public function setDateCreation(DateTimeInterface $dateCreation): self
    {
        $this->dateCreation = $dateCreation;

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
     * @return User
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;
        return $this;
    }

    public function getPhoto(): ?Image
    {
        return $this->photo;
    }

    public function setPhoto(?Image $photo): self
    {
        $this->photo = $photo;

        return $this;
    }

    /**
     * @return Collection|Voyage[]
     */
    public function getVoyages(): Collection
    {
        return $this->voyages;
    }

    /**
     * @param Voyage $voyage
     * @return $this
     */
    public function addVoyage(Voyage $voyage): self
    {
        if (!$this->voyages->contains($voyage)) {
            $this->voyages[] = $voyage;
            $voyage->setUserId($this);
        }
        
         return $this;
    }

    /**
     * @param Voyage $voyage
     * @return $this
     */
    public function removeVoyage(Voyage $voyage): self
    {
        if ($this->voyages->contains($voyage)) {
            $this->voyages->removeElement($voyage);
            // set the owning side to null (unless already changed)
            if ($voyage->getUserId() === $this) {
                $voyage->setUserId(null);
            }
        }

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
            $commentaire->setUserId($this);
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
            if ($commentaire->getUserId() === $this) {
                $commentaire->setUserId(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|self[]
     */
    public function getAmis(): Collection
    {
        return $this->amis;
    }

    public function addAmi(self $ami): self
    {
        if (!$this->amis->contains($ami)) {
            $this->amis[] = $ami;
        }

        return $this;
    }

    public function removeAmi(self $ami): self
    {
        if ($this->amis->contains($ami)) {
            $this->amis->removeElement($ami);
        }

        return $this;
    }

    /**
     * @return Collection|self[]
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(self $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users[] = $user;
            $user->addAmi($this);
        }

        return $this;
    }

    /**
     * @param User $user
     * @return $this
     */
    public function removeUser(self $user): self
    {
        if ($this->users->contains($user)) {
            $this->users->removeElement($user);
            $user->removeAmi($this);
        }

        return $this;
    }

    /**
     * @return Collection|Voyage[]
     */
    public function getVoyagesSuivis(): Collection
    {
        return $this->voyagesSuivis;
    }

    public function addVoyagesSuivi(Voyage $voyagesSuivi): self
    {
        if (!$this->voyagesSuivis->contains($voyagesSuivi)) {
            $this->voyagesSuivis[] = $voyagesSuivi;
        }

        return $this;
    }

    /**
     * @param Voyage $voyagesSuivi
     * @return $this
     */
    public function removeVoyagesSuivi(Voyage $voyagesSuivi): self
    {
        if ($this->voyagesSuivis->contains($voyagesSuivi)) {
            $this->voyagesSuivis->removeElement($voyagesSuivi);
        }
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(?string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(?string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getAge(): ?int
    {
        return $this->age;
    }

    public function setAge(?int $age): self
    {
        $this->age = $age;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getLastLogin()
    {
        return $this->lastLogin;
    }

    /**
     * @param mixed $lastLogin
     * @return User
     */
    public function setLastLogin($lastLogin)
    {
        $this->lastLogin = $lastLogin;
        return $this;
    }


    /**
     * @return string|null
     */
    public function __toString()
    {
        return $this->getEmail();
    }

    /**
     * @ORM\PreUpdate()
     */
    public function DateUpdate()
    {
        $this->setUpdatedAt(new DateTime());
    }

    /**
     * @return bool
     */
    public function isActiveNow()
    {

        $delay = new DateTime('10 minutes ago');

        return ( $this->lastLogin > $delay );
    }
}

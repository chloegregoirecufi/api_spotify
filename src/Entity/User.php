<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    private ?string $email = null;

    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    #[ORM\Column(length: 255)]
    private ?string $nickname = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $created_at = null;

    #[ORM\Column(length: 255)]
    private ?string $role = null;

    #[ORM\Column(length: 255)]
    private ?string $playlist = null;

    #[ORM\OneToMany(targetEntity: Playlist::class, mappedBy: 'user')]
    private Collection $playlisst;

    #[ORM\OneToMany(targetEntity: Preference::class, mappedBy: 'user')]
    private Collection $preference;

    public function __construct()
    {
        $this->playlisst = new ArrayCollection();
        $this->preference = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
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

    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getNickname(): ?string
    {
        return $this->nickname;
    }

    public function setNickname(string $nickname): static
    {
        $this->nickname = $nickname;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeInterface $created_at): static
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getRole(): ?string
    {
        return $this->role;
    }

    public function setRole(string $role): static
    {
        $this->role = $role;

        return $this;
    }

    /**
     * @return Collection<int, Playlist>
     */
    public function getPlaylisst(): Collection
    {
        return $this->playlisst;
    }

    public function addPlaylisst(Playlist $playlisst): static
    {
        if (!$this->playlisst->contains($playlisst)) {
            $this->playlisst->add($playlisst);
            $playlisst->setUser($this);
        }

        return $this;
    }

    public function removePlaylisst(Playlist $playlisst): static
    {
        if ($this->playlisst->removeElement($playlisst)) {
            // set the owning side to null (unless already changed)
            if ($playlisst->getUser() === $this) {
                $playlisst->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Preference>
     */
    public function getPreference(): Collection
    {
        return $this->preference;
    }

    public function addPreference(Preference $preference): static
    {
        if (!$this->preference->contains($preference)) {
            $this->preference->add($preference);
            $preference->setUser($this);
        }

        return $this;
    }

    public function removePreference(Preference $preference): static
    {
        if ($this->preference->removeElement($preference)) {
            // set the owning side to null (unless already changed)
            if ($preference->getUser() === $this) {
                $preference->setUser(null);
            }
        }

        return $this;
    }
}

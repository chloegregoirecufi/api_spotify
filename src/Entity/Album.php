<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\AlbumRepository;
use ApiPlatform\Metadata\ApiResource;

#[ORM\Entity(repositoryClass: AlbumRepository::class)]
//On expose l'entité à l'api
#[ApiResource(
    //On déclare les groupes de serialisation et de déserialisation
    normalizationContext: ['groups' => ['album:read']],
    denormalizationContext: ['groups' => ['album:write']],
)]
// #[ApiFilter(
//     SearchFilter::class, properties: ['id' => 'exact', 'title' => 'exact', 'description' => 'partial', 'genre.label' => 'exact']
// )]
class Album
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column()]
    private ?\DateTimeImmutable $realaseDate = null;

    #[ORM\Column(length: 255)]
    private ?string $imagePath = null;

    #[ORM\Column()]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column()]
    private ?\DateTimeImmutable $updateAt = null;


    #[ORM\ManyToOne(inversedBy: 'albums')]
    private ?Artist $Artist = null;

    #[ORM\ManyToOne(inversedBy: 'albums')]
    private ?Genre $genre = null;

    #[ORM\OneToMany(targetEntity: Song::class, mappedBy: 'album')]
    private Collection $song;

    #[ORM\ManyToMany(targetEntity: User::class, inversedBy: 'albums')]
    private Collection $user;

    public function __construct()
    {
        $this->song = new ArrayCollection();
        $this->user = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getRealaseDate(): ?\DateTimeImmutable
    {
        return $this->realaseDate;
    }

    public function setRealaseDate(\DateTimeImmutable $realaseDate): static
    {
        $this->realaseDate = $realaseDate;

        return $this;
    }

    public function getImagePath(): ?string
    {
        return $this->imagePath;
    }

    public function setImagePath(string $imagePath): static
    {
        $this->imagePath = $imagePath;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdateAt(): ?\DateTimeImmutable
    {
        return $this->updateAt;
    }

    public function setUpdateAt(\DateTimeImmutable $updateAt): static
    {
        $this->updateAt = $updateAt;

        return $this;
    }

    public function __toString(): string
    {
        return $this->title;
    }


    public function getArtist(): ?Artist
    {
        return $this->Artist;
    }

    public function setArtist(?Artist $Artist): static
    {
        $this->Artist = $Artist;

        return $this;
    }

    public function getGenre(): ?Genre
    {
        return $this->genre;
    }

    public function setGenre(?Genre $genre): static
    {
        $this->genre = $genre;

        return $this;
    }

    /**
     * @return Collection<int, Song>
     */
    public function getSong(): Collection
    {
        return $this->song;
    }

    public function addSong(Song $song): static
    {
        if (!$this->song->contains($song)) {
            $this->song->add($song);
            $song->setAlbum($this);
        }

        return $this;
    }

    public function removeSong(Song $song): static
    {
        if ($this->song->removeElement($song)) {
            // set the owning side to null (unless already changed)
            if ($song->getAlbum() === $this) {
                $song->setAlbum(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getUser(): Collection
    {
        return $this->user;
    }

    public function addUser(User $user): static
    {
        if (!$this->user->contains($user)) {
            $this->user->add($user);
        }

        return $this;
    }

    public function removeUser(User $user): static
    {
        $this->user->removeElement($user);

        return $this;
    }


}

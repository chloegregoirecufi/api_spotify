<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiFilter;
use App\Repository\AlbumRepository;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: AlbumRepository::class)]
//on expose l'entité  à l'api
//il suffit simplement de faire référene à ApiRessourse
#[ApiResource]
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

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $realaseDate = null;

    #[ORM\Column(length: 255)]
    private ?string $imagePath = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $createdAt = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $updateAt = null;

    #[ORM\OneToMany(targetEntity: Preference::class, mappedBy: 'album')]
    private Collection $preference;


    #[ORM\ManyToOne(inversedBy: 'albums')]
    private ?Artist $Artist = null;

    #[ORM\ManyToOne(inversedBy: 'albums')]
    private ?Genre $genre = null;

    public function __construct()
    {
        $this->preference = new ArrayCollection();
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

    public function getRealaseDate(): ?\DateTimeInterface
    {
        return $this->realaseDate;
    }

    public function setRealaseDate(\DateTimeInterface $realaseDate): static
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

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdateAt(): ?\DateTimeInterface
    {
        return $this->updateAt;
    }

    public function setUpdateAt(\DateTimeInterface $updateAt): static
    {
        $this->updateAt = $updateAt;

        return $this;
    }

    public function __toString(): string
    {
        return $this->title;
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
            $preference->setAlbum($this);
        }

        return $this;
    }

    public function removePreference(Preference $preference): static
    {
        if ($this->preference->removeElement($preference)) {
            // set the owning side to null (unless already changed)
            if ($preference->getAlbum() === $this) {
                $preference->setAlbum(null);
            }
        }

        return $this;
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


}

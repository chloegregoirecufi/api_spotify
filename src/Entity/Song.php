<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\SongRepository;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;



#[ORM\Entity(repositoryClass: SongRepository::class)]
#[Vich\Uploadable]
class Song
{
    
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;
    
    #[ORM\Column(length: 255)]
    private ?string $title = null;
    
    #[ORM\Column(length: 255)]
    private ?string $file_path = null;
    
    #[ORM\Column(length: 255)]
    private ?string $duration = null;

    //ajout d'une propriété file
    #[Vich\UploadableField(mapping:'songs', fileNameProperty:'filePath')]
    private ?File $filePathFile = null;


    #[ORM\OneToMany(targetEntity: Preference::class, mappedBy: 'song')]
    private Collection $preference;

    #[ORM\ManyToMany(targetEntity: Playlist::class, mappedBy: 'song')]
    private Collection $playlists;

    public function __construct()
    {
        $this->preference = new ArrayCollection();
        $this->playlists = new ArrayCollection();
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
    
    public function getFilePath(): ?string
    {
        return $this->file_path;
    }
    
    public function setFilePath(string $file_path): static
    {
        $this->file_path = $file_path;
        
        return $this;
    }
    
    public function getDuration(): ?string
    {
        return $this->duration;
    }
    
    public function setDuration(string $duration): static
    {
        $this->duration = $duration;
        
        return $this;
    }

    //ici on ajoute les propriétés de filePathFRile
    public function getFilePathFile(): ?File
    {
        return $this->filePathFile;
    }

    public function setFilePathFile(?File $filePathFile = null): void
    {
        $this->filePathFile = $filePathFile;
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
            $preference->setSong($this);
        }

        return $this;
    }

    public function removePreference(Preference $preference): static
    {
        if ($this->preference->removeElement($preference)) {
            // set the owning side to null (unless already changed)
            if ($preference->getSong() === $this) {
                $preference->setSong(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Playlist>
     */
    public function getPlaylists(): Collection
    {
        return $this->playlists;
    }

    public function addPlaylist(Playlist $playlist): static
    {
        if (!$this->playlists->contains($playlist)) {
            $this->playlists->add($playlist);
            $playlist->addSong($this);
        }

        return $this;
    }

    public function removePlaylist(Playlist $playlist): static
    {
        if ($this->playlists->removeElement($playlist)) {
            $playlist->removeSong($this);
        }

        return $this;
    }

    }

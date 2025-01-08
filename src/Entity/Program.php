<?php

namespace App\Entity;

use App\Repository\ProgramRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

#[ORM\Entity(repositoryClass: ProgramRepository::class)]
class Program
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $title = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $summary = null;

    #[ORM\Column(length: 2000, nullable: true)]
    private ?string $poster = null;

    #[ORM\ManyToOne(targetEntity: Category::class, inversedBy: 'programs')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Category $category = null;

    /**
     * @var Collection<int, Seasons>
     */
    #[ORM\OneToMany(targetEntity: Seasons::class, mappedBy: 'program_id')]
    private Collection $seasons;

    /**
     * @var Collection<int, Episodes>
     */
    #[ORM\OneToMany(targetEntity: Episodes::class, mappedBy: 'program')]
    private Collection $episode;

    public function __construct()
    {
        $this->seasons = new ArrayCollection();
        $this->episode = new ArrayCollection();
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

    public function getSummary(): ?string
    {
        return $this->summary;
    }

    public function setSummary(?string $summary): static
    {
        $this->summary = $summary;

        return $this;
    }

    public function getPoster(): ?string
    {
        return $this->poster;
    }

    public function setPoster(?string $poster): static
    {
        $this->poster = $poster;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): static
    {
        $this->category = $category;

        return $this;
    }

    /**
     * @return Collection<int, Seasons>
     */
    public function getSeasons(): Collection
    {
        return $this->seasons;
    }

    public function addSeasons(Seasons $seasons): static
    {
        if (!$this->seasons->contains($seasons)) {
            $this->seasons->add($seasons);
            $seasons->setProgramId($this);
        }

        return $this;
    }

    public function removeSeasons(Seasons $seasons): static
    {
        if ($this->seasons->removeElement($seasons)) {
            // set the owning side to null (unless already changed)
            if ($seasons->getProgramId() === $this) {
                $seasons->setProgramId(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Episodes>
     */
    public function getEpisode(): Collection
    {
        return $this->episode;
    }

    public function addEpisode(Episodes $episode): static
    {
        if (!$this->episode->contains($episode)) {
            $this->episode->add($episode);
            $episode->setProgram($this);
        }

        return $this;
    }

    public function removeEpisode(Episodes $episode): static
    {
        if ($this->episode->removeElement($episode)) {
            // set the owning side to null (unless already changed)
            if ($episode->getProgram() === $this) {
                $episode->setProgram(null);
            }
        }

        return $this;
    }

}

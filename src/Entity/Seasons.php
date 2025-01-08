<?php

namespace App\Entity;

use App\Repository\SeasonsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SeasonsRepository::class)]
class Seasons
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'seasons')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Program $program_id = null;

    #[ORM\Column]
    private ?int $number = null;

    #[ORM\Column(nullable: true)]
    private ?int $year = null;

    #[ORM\Column]
    private ?int $numbersEpisode = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    /**
     * @var Collection<int, Episodes>
     */
    #[ORM\OneToMany(targetEntity: Episodes::class, mappedBy: 'season')]
    private Collection $episode;

    public function __construct()
    {
        $this->episode = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProgramId(): ?Program
    {
        return $this->program_id;
    }

    public function setProgramId(?Program $program_id): static
    {
        $this->program_id = $program_id;

        return $this;
    }

    public function getNumber(): ?int
    {
        return $this->number;
    }

    public function setNumber(int $number): static
    {
        $this->number = $number;

        return $this;
    }

    public function getYear(): ?int
    {
        return $this->year;
    }

    public function setYear(?int $year): static
    {
        $this->year = $year;

        return $this;
    }

    public function getNumbersOfEpisode(): ?int
    {
        return $this->numbersEpisode;
    }

    public function setNumbersEpisode(int $numbersEpisode): static
    {
        $this->numbersEpisode = $numbersEpisode;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

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
            $episode->setSeason($this);
        }

        return $this;
    }

    public function removeEpisode(Episodes $episode): static
    {
        if ($this->episode->removeElement($episode)) {
            // set the owning side to null (unless already changed)
            if ($episode->getSeason() === $this) {
                $episode->setSeason(null);
            }
        }

        return $this;
    }
}

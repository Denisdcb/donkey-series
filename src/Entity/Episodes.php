<?php

namespace App\Entity;

use App\Repository\EpisodesRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EpisodesRepository::class)]
class Episodes
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'episode')]
    #[ORM\JoinColumn(nullable: false)]
    private ?program $program = null;

    #[ORM\ManyToOne(inversedBy: 'episode')]
    #[ORM\JoinColumn(nullable: false)]
    private ?seasons $season = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $title = null;

    #[ORM\Column]
    private ?int $number = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProgram(): ?program
    {
        return $this->program;
    }

    public function setProgram(?program $program): static
    {
        $this->program = $program;

        return $this;
    }

    public function getSeason(): ?seasons
    {
        return $this->season;
    }

    public function setSeason(?seasons $season): static
    {
        $this->season = $season;

        return $this;
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

    public function getNumber(): ?int
    {
        return $this->number;
    }

    public function setNumber(int $number): static
    {
        $this->number = $number;

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
}

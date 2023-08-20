<?php

namespace App\Entity;

use App\Repository\RoverRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;

#[ORM\Entity(repositoryClass: RoverRepository::class)]
class Rover
{
    use TimestampableEntity;
    #[ORM\Id]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $landing_date = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $launch_date = null;

    #[ORM\Column(length: 30)]
    private ?string $status = null;

    #[ORM\Column]
    private ?int $max_sol = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $max_date = null;

    #[ORM\Column]
    private ?int $total_photos = null;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): static
    {
        $this->id = $id;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getLandingDate(): ?\DateTimeInterface
    {
        return $this->landing_date;
    }

    public function setLandingDate(\DateTimeInterface $landing_date): static
    {
        $this->landing_date = $landing_date;

        return $this;
    }

    public function getLaunchDate(): ?\DateTimeInterface
    {
        return $this->launch_date;
    }

    public function setLaunchDate(\DateTimeInterface $launch_date): static
    {
        $this->launch_date = $launch_date;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): static
    {
        $this->status = $status;

        return $this;
    }

    public function getMaxSol(): ?int
    {
        return $this->max_sol;
    }

    public function setMaxSol(int $max_sol): static
    {
        $this->max_sol = $max_sol;

        return $this;
    }

    public function getMaxDate(): ?\DateTimeInterface
    {
        return $this->max_date;
    }

    public function setMaxDate(\DateTimeInterface $max_date): static
    {
        $this->max_date = $max_date;

        return $this;
    }

    public function getTotalPhotos(): ?int
    {
        return $this->total_photos;
    }

    public function setTotalPhotos(int $total_photos): static
    {
        $this->total_photos = $total_photos;

        return $this;
    }
}

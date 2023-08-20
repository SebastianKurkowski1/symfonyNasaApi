<?php

namespace App\Entity;

use App\Repository\MRPRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MRPRepository::class)]
class MRP
{
    #[ORM\Id]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $sol = null;

    #[ORM\Column]
    private ?int $camera_id = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $img_src = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $earth_date = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): static
    {
        $this->id = $id;

        return $this;
    }

    public function getSol(): ?int
    {
        return $this->sol;
    }

    public function setSol(int $sol): static
    {
        $this->sol = $sol;

        return $this;
    }

    public function getCameraId(): ?int
    {
        return $this->camera_id;
    }

    public function setCameraId(int $camera_id): static
    {
        $this->camera_id = $camera_id;

        return $this;
    }

    public function getImgSrc(): ?string
    {
        return $this->img_src;
    }

    public function setImgSrc(string $img_src): static
    {
        $this->img_src = $img_src;

        return $this;
    }

    public function getEarthDate(): ?\DateTimeInterface
    {
        return $this->earth_date;
    }

    public function setEarthDate(\DateTimeInterface $earth_date): static
    {
        $this->earth_date = $earth_date;

        return $this;
    }
}

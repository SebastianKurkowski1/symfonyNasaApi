<?php

namespace App\Entity;

use App\Repository\APODRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;

#[ORM\Entity(repositoryClass: APODRepository::class)]
class APOD
{
    use TimestampableEntity;
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 12, unique: true)]
    private ?string $date = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $explanation = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $hdurl = null;

    #[ORM\Column(length: 20, nullable: true)]
    private ?string $media_type = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(length: 255)]
    private ?string $url = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDate(): ?string
    {
        return $this->date;
    }

    public function setDate(string $date): static
    {
        $this->date = $date;

        return $this;
    }

    public function getExplanation(): ?string
    {
        return $this->explanation;
    }

    public function setExplanation(string $explanation): static
    {
        $this->explanation = $explanation;

        return $this;
    }

    public function getHdurl(): ?string
    {
        return $this->hdurl;
    }

    public function setHdurl(?string $hdurl): static
    {
        $this->hdurl = $hdurl;

        return $this;
    }

    public function getMediaType(): ?string
    {
        return $this->media_type;
    }

    public function setMediaType(string $media_type): static
    {
        $this->media_type = $media_type;

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

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(string $url): static
    {
        $this->url = $url;

        return $this;
    }
}

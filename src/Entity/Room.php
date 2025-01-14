<?php

// src/Entity/Room.php
namespace App\Entity;

use App\Repository\RoomRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RoomRepository::class)]
class Room
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(type: 'string', length: 255)]
    private ?string $name = null;

    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $description = null;

    #[ORM\Column(type: 'float')]
    private ?float $price = null;

    #[ORM\Column(type: 'string', length: 50)]
    private ?string $size = null;

    #[ORM\Column(type: 'string', length: 100)]
    private ?string $bedType = null;

    #[ORM\Column(type: 'integer')]
    private ?int $maxOccupancy = null;

    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $features = null;

    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $bathroomFeatures = null;

    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $furnishings = null;

    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $services = null;

    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $internet = null;

    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $phone = null;

    #[ORM\Column(type: 'string', nullable: true)]
    private $imageFilename = null;



    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;
        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;
        return $this;
    }

    public function getSize(): ?string
    {
        return $this->size;
    }

    public function setSize(string $size): self
    {
        $this->size = $size;
        return $this;
    }

    public function getBedType(): ?string
    {
        return $this->bedType;
    }

    public function setBedType(string $bedType): self
    {
        $this->bedType = $bedType;
        return $this;
    }

    public function getMaxOccupancy(): ?int
    {
        return $this->maxOccupancy;
    }

    public function setMaxOccupancy(int $maxOccupancy): self
    {
        $this->maxOccupancy = $maxOccupancy;
        return $this;
    }

    public function getFeatures(): ?string
    {
        return $this->features;
    }

    public function setFeatures(?string $features): self
    {
        $this->features = $features;
        return $this;
    }

    public function getBathroomFeatures(): ?string
    {
        return $this->bathroomFeatures;
    }

    public function setBathroomFeatures(?string $bathroomFeatures): self
    {
        $this->bathroomFeatures = $bathroomFeatures;
        return $this;
    }

    public function getFurnishings(): ?string
    {
        return $this->furnishings;
    }

    public function setFurnishings(?string $furnishings): self
    {
        $this->furnishings = $furnishings;
        return $this;
    }

    public function getServices(): ?string
    {
        return $this->services;
    }

    public function setServices(?string $services): self
    {
        $this->services = $services;
        return $this;
    }

    public function getInternet(): ?string
    {
        return $this->internet;
    }

    public function setInternet(?string $internet): self
    {
        $this->internet = $internet;
        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(?string $phone): self
    {
        $this->phone = $phone;
        return $this;
    }

    public function getImageFilename(): ?string
    {
        return $this->imageFilename;
    }

    public function setImageFilename(?string $imageFilename): self
    {
        $this->imageFilename = $imageFilename;
        return $this;
    }
}

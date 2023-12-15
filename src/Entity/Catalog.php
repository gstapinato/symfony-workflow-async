<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\CatalogRepository;

use Ramsey\Uuid\Doctrine\UuidGenerator;
use Ramsey\Uuid\UuidInterface;

#[ORM\Entity(repositoryClass: CatalogRepository::class)]
class Catalog
{
    public function __construct(
    #[ORM\Id]
    #[ORM\Column(type: "uuid", unique: true)]
    #[ORM\GeneratedValue(strategy: "CUSTOM")]
    #[ORM\CustomIdGenerator(class: UuidGenerator::class)]
        private UuidInterface|string $id,

    #[ORM\Column(length: 255)]
        private ?string $fileName = null,

    #[ORM\Column(length: 255)]
        private ?string $name = null,
    #[ORM\Column(length: 255, nullable: true)]
        private ?string $description = null,

    #[ORM\Column(type: 'string', enumType: CatalogState::class)]
        private CatalogState $state = CatalogState::INITIALIZED
    ) {
        $this->id = $id;
        $this->fileName = $fileName;
        $this->name = $name;
    }

    public function getId(): UuidInterface|string
    {
        return $this->id;
    }

    public function setId(UuidInterface|string $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getFileName(): ?string
    {
        return $this->fileName;
    }

    public function setFileName(string $fileName): self
    {
        $this->fileName = $fileName;

        return $this;
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

    public function getState(): CatalogState
    {
        return $this->state;
    }

    public function setState(CatalogState $state): self
    {
        $this->state = $state;
        return $this;
    }

    public function getStateAsString(): string
    {
        return $this->state->value;
    }

    public function setStateAsString(string $stateAsString): self
    {
        $this->state = CatalogState::from($stateAsString);

        return $this;
    }

}

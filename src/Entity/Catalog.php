<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Ramsey\Uuid\UuidInterface;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\CatalogRepository;
use Ramsey\Uuid\Doctrine\UuidGenerator;

#[ORM\Entity(repositoryClass: CatalogRepository::class)]
class Catalog
{
    public function __construct(
        #[ORM\Id]
        #[ORM\Column(type: Types::GUID, unique: true)]
        #[ORM\GeneratedValue(strategy: "CUSTOM")]
        #[ORM\CustomIdGenerator(class: UuidGenerator::class)]
        private UuidInterface|string $id,
        #[ORM\Column(length: 255)]
        private ?string $fileName = null,
        #[ORM\Column(length: 255)]
        private ?string $name = null,
        #[ORM\Column(length: 255, nullable: true)]
        private ?string $description = null,
        #[ORM\Column(type: Types::STRING, enumType: CatalogState::class)]
        private CatalogState $state = CatalogState::INITIALIZED
    ) {
    }

    public function getId(): UuidInterface|string
    {
        return $this->id;
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

    /**
     * Summary of setStateAsString
     * @param string $stateAsString
     * @return \App\Entity\Catalog
     * @throws \ValueError::class if state does not exists.
     */
    public function setStateAsString(string $stateAsString): self
    {
        $this->state = CatalogState::from($stateAsString);

        return $this;
    }

}

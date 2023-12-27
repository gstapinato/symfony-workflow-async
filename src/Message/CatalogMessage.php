<?php

declare(strict_types=1);

namespace App\Message;

use Ramsey\Uuid\UuidInterface;

class CatalogMessage
{
    public function __construct(
        private readonly UuidInterface $id,
        private readonly string $name,
        private readonly string $fileName
    ) {
    }

    public function getId(): UuidInterface
    {
        return $this->id;
    }

    public function getFileName(): string
    {
        return $this->fileName;
    }

    public function getName()
    {
        return $this->getName();
    }

}

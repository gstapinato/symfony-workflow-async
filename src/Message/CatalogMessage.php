<?php declare(strict_types=1);

namespace App\Message;

use Ramsey\Uuid\UuidInterface;

class CatalogMessage {
    function __construct(
        private readonly UuidInterface $id,
        private readonly string $name,
        private readonly string $fileName
        ) {
    }

    function getId(): UuidInterface {
        return $this->id;
    }

    function getFileName(): string {
        return $this->fileName;
    }

    function getName()
    {
        return $this->getName();
    }

}
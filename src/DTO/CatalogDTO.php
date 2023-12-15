<?php

namespace App\DTO;


class CatalogDTO
{
    public function __construct(
        public string $fileName,
        public string $name,
    ) {
    }

}

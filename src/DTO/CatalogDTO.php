<?php

namespace App\DTO;

use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Validator\Constraints\NotBlank;
use OpenApi\Attributes as OA;

class CatalogDTO
{
    public function __construct(
        public ?string $id,
        #[OA\Property(description: "File name", example:"fileName.txt")]
        #[Groups(["default"])]        
        #[NotBlank(message: "Description value should not be blank")]
        public string $fileName,
        #[OA\Property(description: "Catalog name", example:"A catalog Name")]
        #[Groups(["default"])]
        public string $name,
    ) {
    }

}

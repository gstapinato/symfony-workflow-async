<?php

namespace App\DTO;

use OpenApi\Attributes as OA;
use PhpParser\Node\Expr\BinaryOp\GreaterOrEqual;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\GreaterThan;

class ProductDTO
{
    public function __construct(
        public ?string $description = null,
        #[NotBlank(message: "Id product supplier should not be blank")]
        public ?string $idProductSupplier = null,
        #[NotBlank(message: "URL should not be blank")]
        public ?string $url = null,
        #[NotBlank(message: "Name should not be blank")]
        public ?string $name = null,
        #[NotBlank(message: "Product category tree should not be blank")]
        public ?string $productCategoryTree = null,
        #[GreaterOrEqual(value:0, message: "Retail price should be greater than zero")]
        public ?float $retailPrice = null,
        #[GreaterOrEqual(value:0, message: "Discounted price should be greater than zero")]
        public ?float $discountedPrice = null,
        public ?string $image = null
    ) {
    }

}

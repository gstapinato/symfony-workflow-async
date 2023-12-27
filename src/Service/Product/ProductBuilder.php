<?php

namespace App\Service\Product;

use App\DTO\ProductDTO;
use App\Entity\Product;
use App\Service\io\FileLine;
use App\Exception\ServiceException;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ProductBuilder
{
    public function __construct(
        private readonly ValidatorInterface $validatorInterface,
    ) {
    }

    /**
     * Build a Product from file line.
     *
     * File line format:
     * 0 => supplier_product_id, 1 => product_url, 2 => product_name, 3 => product_category_tree
     * 4 => retail_price,5 => discounted_price,6 => image,7 => description
     *
     * @param \App\Service\io\FileLine $fileLine
     * @return \App\Entity\Product
     */

    public function build(FileLine $fileLine): Product
    {
        $arr = str_getcsv($fileLine->line);

        if (count($arr) !== 8) {
            throw new ServiceException(
                "Unrecognized record format on line " . $fileLine->numLine . ". File line parsed: " . print_r($arr, true)
            );
        }

        $productDTO = new ProductDTO();
        $productDTO->description = $arr[7];
        $productDTO->idProductSupplier = $arr[0];
        $productDTO->url = $arr[1];
        $productDTO->name = $arr[2];
        $productDTO->productCategoryTree = $arr[3];

        $retailPrice = strlen($arr[4]) == 0 ? "0" : $arr[4];
        if (is_numeric($retailPrice)) {
            $productDTO->retailPrice = floatval($retailPrice);
        } else {
            throw new ServiceException("Retail price should be numeric on line " . $fileLine->numLine . ". Value found: " . $arr[4]);
        }

        $discountedPrice = strlen($arr[5]) == 0 ? "0" : $arr[5];
        if (is_numeric($discountedPrice)) {
            $productDTO->discountedPrice = floatval($discountedPrice);
        } else {
            throw new ServiceException("Discounted price should be numeric on line " . $fileLine->numLine . ". Value found: " . $arr[5]);
        }
        $productDTO->image = $arr[6];

        $violations = $this->validatorInterface->validate($productDTO);
        if (\count($violations)) {
            throw new ServiceException("Validation violation on line " . $fileLine->numLine . ". "
                . implode("\n", array_map(static fn ($e) => $e->getMessage(), iterator_to_array($violations))));
        }

        return Product::createFromProductDTO($productDTO);
    }


}

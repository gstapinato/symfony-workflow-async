<?php

namespace App\Service\Product;

use App\DTO\ProductDTO;
use App\Entity\Product;
use App\Service\io\FileLine;
use PHPUnit\Framework\TestCase;

use App\Exception\ServiceException;
use Symfony\Component\Validator\Validation;

class ProductBuilderTest extends TestCase
{
    public function testBuildOk(): void
    {
        $validator = Validation::createValidator();
        $productBuilder = new ProductBuilder($validator);
        $fileLine = new FileLine(1, "0,1,2,3,4,5,6,7");
        $product = $productBuilder->build($fileLine);

        $this->assertSame("0", $product->getIdProductSupplier());
        $this->assertSame("1", $product->getUrl());
        $this->assertSame("2", $product->getName());
        $this->assertSame("3", $product->getProductCategoryTree());
        $this->assertSame(4.0, $product->getRetailPrice());
        $this->assertSame(5.0, $product->getDiscountedPrice());
        $this->assertSame("6", $product->getImage());
        $this->assertSame("7", $product->getDescription());
    }

    public function testBuildSeparatorWithSemicolonThrowsServiceException(): void
    {
        $validator = Validation::createValidator();
        $productBuilder = new ProductBuilder($validator);
        $fileLine = new FileLine(1, "0;1;2;3;4;5;6;7");

        $this->expectException(ServiceException::class);

        $productBuilder->build($fileLine);
    }

}

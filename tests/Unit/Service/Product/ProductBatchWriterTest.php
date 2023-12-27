<?php

declare(strict_types=1);

namespace App\Tests\Unit\Service\Product;

use App\DTO\ProductDTO;
use App\Entity\Product;
use Doctrine\ORM\EntityManager;
use PHPUnit\Framework\TestCase;
use App\Service\Product\ProductBatchWriter;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\MockObject\MockObject;

/**
 * Summary of ProductBatchWriterTest
 */
class ProductBatchWriterTest extends TestCase
{
    protected function setUp(): void
    {
    }
    public function testWrite(): void
    {
        /**@var  EntityManagerInterface|MockObject */
        $entityManagerMock = $this->createMock(EntityManager::class);
        $entityManagerMock->expects(self::once())
            ->method("persist")
            ->will($this->returnCallback(function (Product $product) {
                self::assertEquals('name', $product->getName());
                self::assertEquals('description', $product->getDescription());
                self::assertEquals('image', $product->getImage());
                self::assertEquals(2, $product->getDiscountedPrice());
                self::assertEquals('pct', $product->getProductCategoryTree());
                self::assertEquals(1, $product->getRetailPrice());
                self::assertEquals('url', $product->getUrl());
                self::assertEquals('1', $product->getIdProductSupplier());
            }));

        $productRepository = new ProductBatchWriter($entityManagerMock);

        $product = Product::createFromProductDTO(new ProductDTO("description", "1", "url", "name", "pct", 1, 2, "image"));
        $productRepository->write([$product]);

    }

}

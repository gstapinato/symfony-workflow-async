<?php

declare(strict_types=1);

namespace App\Tests\Unit\Service;

use App\Entity\Product;
use App\Service\io\FileLine;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Nonstandard\Uuid;
use App\Service\Product\ProductBuilder;
use App\Service\Product\ProductService;
use App\Service\Product\ProductBatchWriter;
use App\Service\io\ReadFileServiceInterface;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\MockObject\Rule\InvokedCount as InvokedCountMatcher;

/**
 * Summary of ProductServiceTest
 */
class ProductServiceTest extends TestCase
{
    protected function setUp(): void
    {
    }
    public function testImportProductsOneBatch(): void
    {

        $readFileServiceMock = $this->createMock(ReadFileServiceInterface::class);
        $readFileServiceMock->method("read")
            ->willReturn((new \ArrayObject([new FileLine(1, "")]))->getIterator())
        ;

        $productBuilder = $this->createMock(ProductBuilder::class);
        $productBuilder->expects(self::once())
            ->method("build")
            ->willReturn(new Product());

        /**@var  ProductBatchWriter|MockObject */
        $productWriter = $this->createMock(ProductBatchWriter::class);
        $productWriter->expects(self::once())
            ->method("write");

        $productService = new ProductService($readFileServiceMock, $productBuilder, $productWriter, 20);
        $productService->importProducts(Uuid::uuid4(), "");
    }
    public function testImportProductsTwoBatch(): void
    {
        $readFileServiceMock = $this->createMock(ReadFileServiceInterface::class);
        $readFileServiceMock->method("read")
            ->willReturn((new \ArrayObject([new FileLine(1, ""), new FileLine(1, "")]))->getIterator());

        $productBuilder = $this->createMock(ProductBuilder::class);
        $productBuilder->expects(new InvokedCountMatcher(2))
            ->method("build")
            ->willReturn(new Product());

        /**@var  ProductBatchWriter|MockObject */
        $productWriter = $this->createMock(ProductBatchWriter::class);
        $productWriter->expects(new InvokedCountMatcher(2))
            ->method("write");

        $productService = new ProductService($readFileServiceMock, $productBuilder, $productWriter, 1);
        $productService->importProducts(Uuid::uuid4(), "");
    }


}

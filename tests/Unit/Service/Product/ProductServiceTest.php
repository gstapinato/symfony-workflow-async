<?php

declare(strict_types=1);

namespace App\Tests\Unit\Service;

use App\Entity\Product;
use App\Service\io\FileLine;
use Psr\Log\LoggerInterface;
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
    private LoggerInterface $logger;

    protected function setUp(): void
    {
        $this->logger = $this->createMock(LoggerInterface::class);
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

        $productService = new ProductService($this->logger, $readFileServiceMock, $productBuilder, $productWriter, 20);
        $this->assertTrue($productService->importProducts(Uuid::uuid4(), ""));
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

        $productService = new ProductService($this->logger, $readFileServiceMock, $productBuilder, $productWriter, 1);
        $this->assertTrue($productService->importProducts(Uuid::uuid4(), ""));
    }

    public function testImportProductsWhenFileNotFound(): void
    {
        $readFileServiceMock = $this->createMock(ReadFileServiceInterface::class);
        $readFileServiceMock->method("read")
            ->willThrowException(new \ErrorException("Error reading file"));
        $productBuilder = $this->createMock(ProductBuilder::class);

        /**@var  ProductBatchWriter|MockObject */
        $productWriter = $this->createMock(ProductBatchWriter::class);

        $productService = new ProductService($this->logger, $readFileServiceMock, $productBuilder, $productWriter, 1);
        $this->assertFalse($productService->importProducts(Uuid::uuid4(), ""));
    }

}

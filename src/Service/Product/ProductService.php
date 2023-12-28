<?php

namespace App\Service\Product;

use DateTime;
use App\DTO\ProductDTO;
use App\Entity\Product;
use Psr\Log\LoggerInterface;
use Ramsey\Uuid\UuidInterface;
use App\Service\io\FileLine;
use App\Exception\ServiceException;
use App\Repository\ProductRepository;
use App\Exception\ServiceHttpException;
use Doctrine\ORM\EntityManagerInterface;
use App\Service\Product\ProductServiceInterface;
use App\Service\io\ReadFileServiceInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Summary of ProductService
 */
final class ProductService implements ProductServiceInterface
{
    public function __construct(
        private readonly LoggerInterface $logger,
        private readonly ReadFileServiceInterface $fileService,
        private readonly ProductBuilder $productBuilder,
        private readonly ProductBatchWriter $productBatchWriter,
        private readonly int $fileBatchSize,
    ) {
    }

    public function importProducts(UuidInterface $catalogId, string $fileName): bool
    {

        try {
            $iterator = $this->fileService->read($fileName, true, FileLine::class);
            $products = [];

            while ($iterator->valid()) {
                $products[] = $this->productBuilder->build($iterator->current());

                if ((count($products) % $this->fileBatchSize) === 0) {
                    $this->productBatchWriter->write($products);
                    $products = [];
                }
                $iterator->next();
            }
            if (count($products) > 0) {
                $this->productBatchWriter->write($products);
            }
            return true;
        } catch (\RuntimeException | \ErrorException $exception) {
            $this->logger->error("Unexpected import products failed.", ['exception' => $exception]);
            return false;
        }
    }


}

<?php

namespace App\Service\Product;

use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Summary of ProductBatchWriter

 */
class ProductBatchWriter
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
    ) {
    }

    /**
     * Summary of write
     * @param Product[] $product
     * @return void
     */
    public function write(array $products)
    {
        /**
         * Improving performance disabling SQL logger
         * @see https://www.doctrine-project.org/projects/doctrine-orm/en/2.17/reference/batch-processing.html
         */
        $this->entityManager->getConnection()?->getConfiguration()?->setMiddlewares([]);

        foreach ($products as $product) {
            $this->entityManager->persist($product);
        }
        $this->entityManager->flush();
        $this->entityManager->clear();
    }
}

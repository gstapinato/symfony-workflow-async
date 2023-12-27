<?php

namespace App\Service\Product;

use Ramsey\Uuid\UuidInterface;

interface ProductServiceInterface
{
    /**
     * Summary of importProducts
     * @param \Ramsey\Uuid\UuidInterface $id
     * @param string $fileName
     * @return void
     * @throws \ErrorException If the file could not be read.
     */
    public function importProducts(UuidInterface $id, string $fileName): void;

}

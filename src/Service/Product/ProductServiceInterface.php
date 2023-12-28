<?php

namespace App\Service\Product;

use Ramsey\Uuid\UuidInterface;

interface ProductServiceInterface
{
    /**
     * Summary of importProducts
     * @param \Ramsey\Uuid\UuidInterface $id
     * @param string $fileName
     * @return void true if success
     */
    public function importProducts(UuidInterface $id, string $fileName): bool;

}

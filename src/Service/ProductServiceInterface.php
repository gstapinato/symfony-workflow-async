<?php

namespace App\Service;

use Ramsey\Uuid\UuidInterface;

/**
 * Summary of ProductService
 
 */
interface ProductServiceInterface
{
     public function importProducts(UuidInterface $id, string $fileName): void;

}

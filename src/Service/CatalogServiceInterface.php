<?php

namespace App\Service;

use App\DTO\CatalogDTO;
use App\Entity\Catalog;
use Ramsey\Uuid\UuidInterface;

/**
 * Summary of QueueService
 
 */
interface CatalogServiceInterface
{

    /**
     * Add a catalog on pending state.
     * @param \App\DTO\CatalogDTO $catalogDTO
     * @return \Ramsey\Uuid\UuidInterface
     */
    public function create(CatalogDTO $catalogDTO): CatalogDTO;
    /**
     * Change catalog status to processing.
     * @param string $id
     * @return void
     */
    public function start(UuidInterface $id): void;
    /**
     * Change catalog status to publish.
     * @param string $id
     * @return void
     */
    public function publish(UuidInterface $id): void;

    /**
     * Start batch processing.
     * @param \App\Entity\Catalog $catalog
     * @return void
     */
    public function importProducts(Catalog $catalog): void;

    /**
     * Change catalog status to success.
     * @param \App\Entity\Catalog $catalog
     * @return void
     */
    public function successImport(Catalog $catalog): void;


}

<?php

namespace App\Service;

use App\DTO\CatalogDTO;
use App\Entity\CatalogState;
use Ramsey\Uuid\UuidInterface;

/**
 * Summary of CatalogServiceInterface
 */
interface CatalogServiceInterface
{
    /**
     * Add a catalog on pending state.
     * @param CatalogDTO $catalogDTO
     * @return UuidInterface
     */
    public function create(CatalogDTO $catalogDTO): CatalogDTO;
    /**
     * Change catalog status to publish.
     * @param UuidInterface $id
     * @return void
     */
    public function setCatalogStatusAsPublished(UuidInterface $id): void;

    /**
     * Change catalog status to success.
     * @param UuidInterface $id
     * @return void
     */
    public function setCatalogStatusAsSuccess(UuidInterface $id): void;

    /**
     * Change catalog status to success.
     * @param UuidInterface $id
     * @return void
     */
    public function setCatalogStatusAsFailed(UuidInterface $id): void;

    /**
     * Get catalog status
     * @param UuidInterface $id
     * @return CatalogState
     */
    public function getCatalogStatus(UuidInterface $id): CatalogState;
}

<?php

namespace App\Service;

use Ramsey\Uuid\Uuid;
use App\DTO\CatalogDTO;
use App\Entity\Catalog;
use App\Entity\CatalogState;
use Psr\Log\LoggerInterface;
use Ramsey\Uuid\UuidInterface;
use App\Entity\CatalogTransition;
use App\Repository\CatalogRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Workflow\WorkflowInterface;

/**
 * Summary of QueueService
 
 */
final class ProductService implements ProductServiceInterface
{
    public function __construct(
        private readonly LoggerInterface $logger,
        private readonly CatalogRepository $catalogRepository,
        private readonly WorkflowInterface $catalogStateMachine,
        private readonly EntityManagerInterface $entityManager,
        private CatalogServiceInterface $catalogServiceInterface,
        
    ) {
    }

    public function importProducts(UuidInterface $catalogId, string $fileName): void
    {
        //TODO: Import products from file
        sleep(10);
        //TODO: Create an event when successful import has finished.
        $this->catalogServiceInterface->successImport($catalogId);

    }

}

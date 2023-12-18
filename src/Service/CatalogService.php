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
final class CatalogService implements CatalogServiceInterface
{    
    public function __construct(
        private readonly LoggerInterface $logger,
        private readonly CatalogRepository $catalogRepository,
        private readonly WorkflowInterface $catalogStateMachine,
        private readonly EntityManagerInterface $entityManager,
        
    ) {
    }

    public function create(CatalogDTO $catalogDTO): CatalogDTO
    {
        $catalog = new Catalog(
            Uuid::uuid4(),
            $catalogDTO->name,
            $catalogDTO->fileName
        );

        $this->catalogStateMachine->apply($catalog, CatalogTransition::TO_PROCESSING->value);

        return new CatalogDTO($catalog->getId(), $catalog->getFileName(), $catalog->getName());
    }

    public function successImport(UuidInterface $id): void
    {
        $catalog = $this->catalogRepository->findOrFail($id);
        $this->catalogStateMachine->apply($catalog, CatalogTransition::TO_SUCCESS->value);
    }

    public function publish(UuidInterface $id): void
    {
        $catalog = $this->catalogRepository->findOrFail($id);
        $this->catalogStateMachine->apply($catalog, CatalogTransition::TO_PUBLISHED->value);
    }

}

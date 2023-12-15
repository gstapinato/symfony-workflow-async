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

    public function add(CatalogDTO $catalogDTO): UuidInterface
    {
        $catalog = new Catalog(
            Uuid::uuid4()->toString(),
            $catalogDTO->name,
            $catalogDTO->fileName
        );

        $this->catalogStateMachine->apply($catalog, CatalogTransition::TO_PENDING->value);
        return $catalog->getId();
    }
    public function start(UuidInterface $id): void
    {
        $catalog = $this->catalogRepository->findOrFail($id);
        $this->catalogStateMachine->apply($catalog, CatalogTransition::TO_PROCESSING->value);
    }


    public function importProducts(Catalog $catalog): void
    {
        //TODO: Start import products command here
    }

    public function successImport(Catalog $catalog): void
    {
        $this->catalogStateMachine->apply($catalog, CatalogTransition::TO_SUCCESS->value);
    }

    public function publish(UuidInterface $id): void
    {
        $catalog = $this->catalogRepository->find($id);
        $this->catalogStateMachine->apply($catalog, CatalogTransition::TO_PUBLISHED->value);
    }

}

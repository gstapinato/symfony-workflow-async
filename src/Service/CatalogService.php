<?php

namespace App\Service;

use App\Exception\ServiceHttpException;
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
use Symfony\Component\Workflow\Exception\NotEnabledTransitionException;

/**
 * Summary of CatalogService

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
            $catalogDTO->fileName,
            $catalogDTO->name
        );

        $this->setCatalogStatus($catalog, CatalogTransition::TO_PROCESSING);
        return new CatalogDTO($catalog->getId(), $catalog->getFileName(), $catalog->getName());
    }

    public function setCatalogStatusAsSuccess(UuidInterface $id): void
    {
        $catalog = $this->catalogRepository->findOrFail($id);
        $this->setCatalogStatus($catalog, CatalogTransition::TO_SUCCESS);
    }

    public function setCatalogStatusAsFailed(UuidInterface $id): void
    {
        $catalog = $this->catalogRepository->findOrFail($id);
        $this->setCatalogStatus($catalog, CatalogTransition::TO_FAILED);
    }

    public function setCatalogStatusAsPublished(UuidInterface $id): void
    {
        $catalog = $this->catalogRepository->findOrFail($id);
        $this->setCatalogStatus($catalog, CatalogTransition::TO_PUBLISHED);
    }
    public function getCatalogStatus(UuidInterface $id): CatalogState
    {
        $catalog = $this->catalogRepository->findOrFail($id);
        return $catalog->getState();
    }

    private function setCatalogStatus(Catalog $catalog, CatalogTransition $catalogTransition): void
    {
        try {
            $this->catalogStateMachine->apply($catalog, $catalogTransition->value);
        } catch(NotEnabledTransitionException $exception) {
            throw ServiceHttpException::createValidationException($exception->getMessage(), $exception);
        }
    }

}

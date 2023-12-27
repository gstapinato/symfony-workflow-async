<?php

declare(strict_types=1);

namespace App\Controller;

use Ramsey\Uuid\Uuid;
use App\DTO\CatalogDTO;

use Psr\Log\LoggerInterface;
use OpenApi\Attributes as OA;
use App\Service\CatalogServiceInterface;
use Nelmio\ApiDocBundle\Annotation\Model;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

use Symfony\Component\Routing\Requirement\Requirement;

use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/api/catalog', name: 'catalog_')]
#[OA\Tag(name: 'catalog')]

class CatalogController extends AbstractController
{
    public function __construct(
        private LoggerInterface $logger,
        private CatalogServiceInterface $catalogService
    ) {
    }

    /**
     * Create a new catalog
     */
    #[Route('/create', name: 'create', methods: ['POST'])]
    #[OA\RequestBody(
        content: new OA\JsonContent(
            ref: new Model(type: CatalogDTO::class, groups: ['default'])
        )
    )]
    #[OA\Response(
        response: Response::HTTP_CREATED,
        description: 'Catalog created',
        content: new OA\JsonContent(ref: new Model(type: CatalogDTO::class))
    )]
    public function create(#[MapRequestPayload] CatalogDTO $catalogDTO): JsonResponse
    {
        return $this->json(
            $this->catalogService->create($catalogDTO),
            Response::HTTP_CREATED
        );
    }

    /**
     * Publish a catalog.
     */
    #[OA\Parameter(
        name: "id",
        in:"path",
        required:true,
        example: "550e8400-e29b-41d4-a716-446655440000",
        schema: new OA\Schema(type:"string")
    )]
    #[OA\Response(
        response: Response::HTTP_OK,
        description: 'Catalog published',
        content: new OA\JsonContent(ref: new Model(type: CatalogDTO::class))
    )]
    #[OA\Response(
        response: Response::HTTP_NOT_FOUND,
        description: 'Catalog not found',
        content: new OA\JsonContent(ref: new Model(type: CatalogDTO::class))
    )]

    #[Route('/publish/{id}', name: 'publish', methods: ['PUT'], requirements: ['id' => Requirement::UUID_V4])]
    public function publish(string $id): JsonResponse
    {
        $this->catalogService->setCatalogStatusAsPublished(Uuid::fromString($id));
        return $this->json(null);
    }

    #[Route('/status/{id}', name: 'status', methods: ['GET'], requirements: ['id' => Requirement::UUID_V4])]
    public function status(string $id): JsonResponse
    {
        return $this->json($this->catalogService->getCatalogStatus(Uuid::fromString($id))->value);
    }

}

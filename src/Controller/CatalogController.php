<?php declare(strict_types=1);

namespace App\Controller;

use App\DTO\CatalogDTO;
use Psr\Log\LoggerInterface;

use App\Service\CatalogServiceInterface;
use Ramsey\Uuid\Uuid;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


#[Route('/api/catalog', name: 'catalog_')]

class CatalogController extends AbstractController
{

    function __construct(
        private LoggerInterface $logger,
        private CatalogServiceInterface $catalogService)
    {
    }


    #[Route('/add', name: 'add', methods: ['POST'])]
    public function add(#[MapRequestPayload] CatalogDTO $catalogDTO): JsonResponse
    {
        $id = $this->catalogService->add($catalogDTO)->toString();
        return $this->json(["id" => $id], Response::HTTP_CREATED);
    }

    #[Route('/start', name: 'start', methods: ['POST'])]
    public function start(Request $request): JsonResponse
    {
        $id = $request->getPayload()->get("id");
        $this->catalogService->start(Uuid::fromString($id));
        return $this->json(null);
    }

    #[Route('/publish', name: 'publish', methods: ['POST'])]
    public function publish(Request $request): JsonResponse
    {
        $id = $request->getPayload()->get("id");
        $this->catalogService->publish(Uuid::fromString($id));
        return $this->json(null);
    }

}

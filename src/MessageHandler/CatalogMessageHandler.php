<?php

declare(strict_types=1);

namespace App\MessageHandler;

use DateTime;
use Psr\Log\LoggerInterface;

use App\Message\CatalogMessage;
use App\Service\CatalogServiceInterface;
use App\Service\Product\ProductServiceInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Component\Messenger\Exception\UnrecoverableMessageHandlingException;

#[AsMessageHandler]
class CatalogMessageHandler
{
    public function __construct(
        private LoggerInterface $logger,
        private ProductServiceInterface $productServiceInterface,
        private readonly CatalogServiceInterface $catalogServiceInterface,
    ) {
    }

    public function __invoke(CatalogMessage $message)
    {
        try {
            $dateTime = new DateTime();
            $this->logger->info("Starting to import products", (array) $message);
            $this->productServiceInterface->importProducts($message->getId(), $message->getFileName());
            $diff = (new DateTime())->getTimestamp() - $dateTime->getTimestamp();
            $this->catalogServiceInterface->setCatalogStatusAsSuccess($message->getId());
            $this->logger->info("Import products finished. Time elapsed: $diff seconds");
        } catch (\RuntimeException $exception) {
            $this->logger->error("Import products failed.", ['exception' => $exception]);

            $this->catalogServiceInterface->setCatalogStatusAsFailed($message->getId());
            throw new UnrecoverableMessageHandlingException($exception->getMessage(), $exception->getCode(), $exception);
        }
    }

}

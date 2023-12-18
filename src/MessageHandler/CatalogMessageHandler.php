<?php declare(strict_types=1);

namespace App\MessageHandler;

use App\Service\ProductServiceInterface;
use Psr\Log\LoggerInterface;

use App\Message\CatalogMessage;
use App\Service\CatalogServiceInterface;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class CatalogMessageHandler {

    function __construct(
        private LoggerInterface $logger,
        private ProductServiceInterface $productServiceInterface
        ) {
    }

    function __invoke(CatalogMessage $message) {
        $this->logger->info("Starting first message handler with id ". $message->getId());
        $this->productServiceInterface->importProducts($message->getId(), $message->getFileName());        
        $this->logger->info("End handler");
 
    }

}
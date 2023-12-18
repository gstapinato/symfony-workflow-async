<?php declare(strict_types=1);

namespace App\StateMachine;

use App\Entity\Catalog;
use App\Entity\CatalogState;
use Psr\Log\LoggerInterface;
use App\Message\CatalogMessage;
use App\Service\CatalogService;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Workflow\Event\EnteredEvent;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Workflow\Attribute\AsEnteredListener;
use Symfony\Component\Messenger\Transport\Serialization\SerializerInterface;

class StateMachineListener
{


    function __construct(
        private readonly CatalogService $catalogService,
        private readonly LoggerInterface $logger,
        private readonly SerializerInterface $serializer,
        private readonly EntityManagerInterface $entityManager,
        private readonly MessageBusInterface $messageBusInterface,

    ) {
    }

    #[AsEnteredListener(workflow: 'catalog', place: CatalogState::PROCESSING->value)]
    public function onToProcessingEntered(EnteredEvent $event): void
    {
        /** @var Catalog $catalog */
        $catalog = $event->getSubject();
        $catalogMessage = new CatalogMessage($catalog->getId(), $catalog->getName(), $catalog->getFileName());
        $this->messageBusInterface->dispatch($catalogMessage);

    }

    #[AsEnteredListener(workflow: 'catalog')]
    public function onEnteredListener(EnteredEvent $event): void
    {
        /** @var Catalog $catalog */
        $catalog = $event->getSubject();
        $this->entityManager->persist($catalog);
        $this->entityManager->flush();

    }


}
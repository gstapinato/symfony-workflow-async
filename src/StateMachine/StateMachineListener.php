<?php declare(strict_types=1);

namespace App\StateMachine;

use App\Entity\Catalog;
use App\Entity\CatalogState;
use App\Repository\CatalogRepository;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;

use App\Service\CatalogService;
use App\Service\MessageService;

use App\Service\QueueEventsEnum;
use App\Entity\CatalogTransition;
use Symfony\Component\Workflow\Event\EnteredEvent;
use Symfony\Component\Workflow\Event\TransitionEvent;
use Symfony\Component\Workflow\Attribute\AsEnteredListener;
use Symfony\Component\Workflow\Attribute\AsTransitionListener;
use Symfony\Component\Messenger\Event\WorkerMessageFailedEvent;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\Messenger\Event\WorkerMessageHandledEvent;
use Symfony\Component\Messenger\Event\WorkerMessageRetriedEvent;
use Symfony\Component\Messenger\Event\WorkerMessageReceivedEvent;
use Symfony\Component\Messenger\Transport\Serialization\SerializerInterface;

class StateMachineListener
{


    function __construct(
        private readonly CatalogService $catalogService,
        private readonly LoggerInterface $logger,
        private readonly SerializerInterface $serializer,
        private readonly EntityManagerInterface $entityManager,

    ) {
    }

    #[AsEnteredListener(workflow: 'catalog', place: CatalogState::PROCESSING->value)]
    public function onToProcessingEntered(EnteredEvent $event): void
    {
        /** @var Catalog $catalog */
        $catalog = $event->getSubject();
        $this->catalogService->importProducts($catalog);

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
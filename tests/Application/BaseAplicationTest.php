<?php

declare(strict_types=1);

namespace App\Tests\Application;

use LogicException;
use Doctrine\ORM\Tools\SchemaTool;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;

abstract class BaseAplicationTest extends WebTestCase
{
    protected KernelBrowser $client;

    protected ?EntityManagerInterface $entityManager;

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->initDatabase();

        if ('test' !== $this->client->getKernel()->getEnvironment()) {
            throw new LogicException('Execution only in Test environment possible!');
        }
        $this->entityManager = $this->client->getKernel()->getContainer()
            ->get('doctrine')
            ->getManager();

        $this->initDatabase();

    }

    protected function initDatabase(): void
    {
        $container = static::getContainer();
        $entityManager = $container->get('doctrine.orm.entity_manager');
        $metaData = $entityManager->getMetadataFactory()->getAllMetadata();
        $schemaTool = new SchemaTool($entityManager);
        $schemaTool->updateSchema($metaData);
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        // doing this is recommended to avoid memory leaks
        $this->entityManager->close();
        $this->entityManager = null;
    }
}

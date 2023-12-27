<?php

declare(strict_types=1);

namespace App\Tests\Application\Controller;

use App\Entity\Catalog;
use App\Entity\CatalogState;
use Ramsey\Uuid\Uuid;
use App\Tests\Application\BaseAplicationTest;

class CatalogControllerTest extends BaseAplicationTest
{
    public function testCatalogCreate(): void
    {
        $this->client->jsonRequest('POST', '/api/catalog/create', ["name" => uniqid(), "fileName" => uniqid()]);
        $this->assertResponseIsSuccessful();
        $id = json_decode($this->client->getResponse()->getContent(), true)["id"];

        $this->assertEquals(preg_match('/[0-9a-f]{8}\-[0-9a-f]{4}\-[0-9a-f]{4}\-[0-9a-f]{4}\-[0-9a-f]{12}/', $id), true);

        $catalog = $this->entityManager->getRepository(Catalog::class)->find(Uuid::fromString($id));
        $this->assertEquals($catalog->getState(), CatalogState::PROCESSING);


    }

    public function testCatalogPublish(): void
    {
        $this->client->disableReboot();

        $this->client->jsonRequest('POST', '/api/catalog/create', ["name" => uniqid(), "fileName" => uniqid()]);
        $this->assertResponseIsSuccessful();

        $idString = json_decode($this->client->getResponse()->getContent(), true)["id"];
        $id = Uuid::fromString($idString);

        //Force to change catalog status to sucess.
        $catalog = $this->entityManager->getRepository(Catalog::class)->find($id);
        $catalog->setState(CatalogState::SUCCESS);
        $this->entityManager->persist($catalog);
        $this->entityManager->flush();
        $this->client->jsonRequest('PUT', "/api/catalog/publish/$idString");
        $this->assertResponseIsSuccessful();

        $catalog = $this->entityManager->getRepository(Catalog::class)->find($id);
        $this->assertEquals($catalog->getState(), CatalogState::PUBLISHED);
        $this->client->enableReboot();
    }

}

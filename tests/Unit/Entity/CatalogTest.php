<?php

namespace App\Tests\Unit\Entity;

use Ramsey\Uuid\Uuid;
use App\Entity\Catalog;
use App\Entity\CatalogState;
use PHPUnit\Framework\TestCase;

class CatalogTest extends TestCase
{
    public function testSetStateAsStringSuccess(): void
    {
        $catalog = new Catalog(Uuid::uuid4());
        $catalog->setStateAsString(CatalogState::INITIALIZED->value);
        $this->assertEquals($catalog->getState(), CatalogState::INITIALIZED);

    }
    public function testSetStateAsStringFailed(): void
    {
        $this->expectException(\ValueError::class);
        $this->expectExceptionMessage('"foobar" is not a valid backing value');
        $catalog = new Catalog(Uuid::uuid4());
        $catalog->setStateAsString("foobar");
    }

}

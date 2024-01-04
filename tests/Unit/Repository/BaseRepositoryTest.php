<?php

declare(strict_types=1);

namespace App\Tests\Unit\Repository;

use PHPUnit\Framework\TestCase;
use App\Repository\BaseRepository;
use App\Tests\Unit\Repository\FooTest;
use App\Exception\ServiceHttpException;


/**
 * Summary of BaseRepositoryTest
 */
class BaseRepositoryTest extends TestCase
{
    private BaseRepository|MockObject $baseRepository;

    protected function setUp(): void
    {
        $this->baseRepository = $this->getMockBuilder(BaseRepository::class)
            ->disableOriginalConstructor()
            ->setMethods(["find"])->getMock();
    }
    public function testFindOrFailWhenEntityIsFound(): void
    {
        $fooTest = new FooTest();
        $this->baseRepository
            ->expects(self::once())
            ->method("find")
            ->willReturn($fooTest);

        $entity = $this->baseRepository->findOrFail("1");
        $this->assertSame($fooTest, $entity);

    }
    public function testFindOrFailWhenEntityIsNotFound(): void
    {
        $this->baseRepository
            ->expects(self::once())
            ->method("find")
            ->willReturn(null);

        $this->expectException(ServiceHttpException::class);
        $this->baseRepository->findOrFail("1");
    }

}

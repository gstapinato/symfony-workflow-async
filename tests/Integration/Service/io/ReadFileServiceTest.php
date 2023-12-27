<?php

declare(strict_types=1);

namespace App\Tests\Integration\Service\io;

use App\Service\io\FileLine;
use Safe\Exceptions\FilesystemException;
use App\Service\io\ReadFileService;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

/**
 * Summary of ReadFileServiceTest
 * Notes:
 * Generator function does not execute immediately when you call it. To execute the function it's needed to start consuming the generator
 */
class ReadFileServiceTest extends KernelTestCase
{
    public function testReadFileWhenAppNotFoundFile(): void
    {
        $container = static::getContainer();

        /** @var ReadFileService $readFileService*/
        $readFileService = $container->get(ReadFileService::class);
        $this->expectException(FilesystemException::class);

        $a = $readFileService->read("FileNotFound.txt", true, FileLine::class);

        $a->next();
    }
    public function testReadFileWhenFileContainsTwoLines(): void
    {
        $container = static::getContainer();

        /** @var ReadFileService $readFileService*/
        $readFileService = $container->get(ReadFileService::class);
        $iterator = $readFileService->read("file_two_records.txt", false, FileLine::class);

        $this->assertEquals($iterator->current()->line, "firstLine");
        $this->assertEquals($iterator->current()->numLine, 1);
        $iterator->next();
        $this->assertEquals($iterator->current()->numLine, 2);
        $this->assertEquals($iterator->current()->line, "secondLine");
    }

}

<?php

namespace App\Service\io;

/**
 * Summary of TextFileServiceInterface

 */
interface ReadFileServiceInterface
{
    /**
     * Read a file and return a generator function for each line on the file
     * @template T
     * @param string $fileName
     * @param bool true if skip first line
     * @param class-string<T> $className
     * @return \Generator<T>
     * @throws \ErrorException If the file could not be read.
     */
    public function read(string $fileName, bool $skipFirstLine, $className): \Iterator;

}

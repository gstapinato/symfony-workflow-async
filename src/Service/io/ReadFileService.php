<?php

namespace App\Service\io;

/**
 * Summary of ReadFileService

 */
final class ReadFileService implements ReadFileServiceInterface
{
    public function __construct(
        private string $storagePath,
    ) {
    }

    /**
     * @template T
     * Summary of read
     * @param string $fileName
     * @param bool $skipFirstRow
     * @param class-string<T> $className
     * @return \Iterator<T>
     */
    public function read(string $fileName, bool $skipFirstRow, $className): \Iterator
    {

        $filePath = $this->storagePath . DIRECTORY_SEPARATOR . $fileName;
        $handle = \Safe\fopen($filePath, "r");
        $rowIndex = 1;
        if ($skipFirstRow) {
            fgets($handle);
            $rowIndex++;
        }

        while (!feof($handle)) {
            yield new $className($rowIndex, trim(fgets($handle)));
            $rowIndex++;
        }
        fclose($handle);

    }

}

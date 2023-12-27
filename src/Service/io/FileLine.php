<?php

namespace App\Service\io;

/**
 * Summary of FileLine

 */
final class FileLine
{
    public function __construct(
        public readonly int $numLine,
        public readonly string $line,
    ) {
    }
}

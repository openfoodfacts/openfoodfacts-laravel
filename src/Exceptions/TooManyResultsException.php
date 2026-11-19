<?php

namespace OpenFoodFacts\Laravel\Exceptions;

use RuntimeException;

class TooManyResultsException extends RuntimeException
{
    public function __construct(
        public readonly int $totalMatches,
        public readonly int $maxResults
    ) {
        parent::__construct("ERROR: {$totalMatches} results found, while buffer limited to {$maxResults}. Please narrow your search.");
    }
}

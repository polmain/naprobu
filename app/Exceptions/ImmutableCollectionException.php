<?php

namespace App\Exceptions;

use Exception;

final class ImmutableCollectionException extends Exception
{
    private const ERROR_DESCRIPTION = 'Attempt to mutate immutable "%s" with method "%s"';

    public function __construct(string $collectionClass, string $collectionMethod)
    {
        parent::__construct(sprintf(self::ERROR_DESCRIPTION, $collectionClass, $collectionMethod));
    }
}

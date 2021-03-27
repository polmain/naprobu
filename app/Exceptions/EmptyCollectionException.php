<?php


namespace App\Exceptions;

use Exception;

class EmptyCollectionException extends Exception
{
    private const ERROR_DESCRIPTION = 'Collection %s is expected to be not empty';

    public function __construct(string $collectionClass)
    {
        parent::__construct(sprintf(self::ERROR_DESCRIPTION, $collectionClass));
    }
}

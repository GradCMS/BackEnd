<?php

namespace App\Exceptions;

use RuntimeException;

/**
 * this exception is thrown when some methods of implemented interface is empty
 *
 */
class MethodNotImplementedException extends RuntimeException
{
    public function __construct(string $className, string $methodName)
    {
        $message = "The class {$className} does not implement the method {$methodName}.";
        parent::__construct($message);
    }
}

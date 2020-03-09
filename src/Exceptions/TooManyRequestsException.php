<?php

namespace TarfinLabs\Parasut\Exceptions;

use Exception;

class TooManyRequestsException extends Exception
{
    /**
     * Create a TooManyRequestsException.
     *
     * @param  array  $json
     */
    public function __construct(array $json)
    {
        $a = 4;
        parent::__construct("value");
    }
}

<?php

namespace TarfinLabs\Parasut\Exceptions;

use Exception;

class BadRequestException extends Exception
{
    /**
     * Create a BadRequestException.
     *
     * @param  mixed                $invalidValue
     * @param  \BenSampo\Enum\Enum  $enum
     *
     * @return void
     */
    public function __construct($invalidValue)
    {
        parent::__construct("Cannot construct an instance of $enumClassName using the value ($invalidValueType) `$invalidValue`. Possible values are [$enumValues].");
    }
}

<?php

namespace TarfinLabs\Parasut\Exceptions;

class UnprocessableEntityException extends BaseException
{
    public static int $statusCode = 422;
}

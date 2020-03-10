<?php

namespace TarfinLabs\Parasut\Exceptions;

class BadRequestException extends BaseException
{
    public static int $statusCode = 400;
}

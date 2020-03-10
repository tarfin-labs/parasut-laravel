<?php

namespace TarfinLabs\Parasut\Exceptions;

class UnauthorizedException extends BaseException
{
    public static int $statusCode = 401;
}

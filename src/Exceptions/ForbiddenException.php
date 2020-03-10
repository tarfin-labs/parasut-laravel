<?php

namespace TarfinLabs\Parasut\Exceptions;

class ForbiddenException extends BaseException
{
    public static int $statusCode = 403;
}

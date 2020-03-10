<?php

namespace TarfinLabs\Parasut\Exceptions;

class NotFoundException extends BaseException
{
    public static int $statusCode = 404;
}

<?php

namespace TarfinLabs\Parasut\Exceptions;

class TooManyRequestsException extends BaseException
{
    public static int $statusCode = 429;
}

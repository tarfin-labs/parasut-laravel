<?php

namespace TarfinLabs\Parasut\Exceptions;

use Exception;
use Illuminate\Http\Client\Response;

abstract class BaseException extends Exception
{
    public static int $statusCode;

    /**
     * Create an Exception.
     *
     * @param  \Illuminate\Http\Client\Response  $response
     */
    public function __construct(Response $response)
    {
        $message = array_key_exists('error', $response->json())
            ? "{$response->json()['error']}: {$response->json()['error_description']}"
            : "{$response->json()['errors'][0]['title']}: {$response->json()['errors'][0]['detail']}";

        parent::__construct(
            $message,
            $response->status()
        );
    }
}

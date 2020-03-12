<?php

namespace TarfinLabs\Parasut\Enums;

class ResourceNames
{
    public const CONTACT = 'contacts';
    public const PRODUCT = 'products';

    /**
     * Build the endpoint string from array or string parts.
     *
     * @param  mixed  ...$endpoints
     *
     * @return string
     */
    public static function buildEndpoint(...$endpoints): string
    {
        $url = '';

        foreach ($endpoints as $endpoint) {
            if (is_string($endpoint))
            {
                $url .= "{$endpoint}/";
            }

            if (is_array($endpoint))
            {
                $url .= implode('/', $endpoint);
            }
        }

        return $url;
    }
}

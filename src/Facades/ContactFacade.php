<?php

namespace TarfinLabs\Parasut\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \TarfinLabs\Parasut\Skeleton\SkeletonClass
 */
class ContactFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return 'parasut.contact';
    }
}

<?php

namespace TarfinLabs\ParasutLaravel;

use Illuminate\Support\Facades\Facade;

/**
 * @see \TarfinLabs\ParasutLaravel\Skeleton\SkeletonClass
 */
class ParasutLaravelFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return 'parasut';
    }
}

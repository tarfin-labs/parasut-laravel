<?php

namespace TarfinLabs\Parasut\Mocks;

use Faker\Factory;
use Illuminate\Http\Response;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Http;

class ParasutMock
{
    private static function getJsonContentType(): array
    {
        return ['content-type' => 'application/json; charset=utf-8'];
    }
}
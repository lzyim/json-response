<?php

namespace Soloslee\JsonResponse\Facades;

use Illuminate\Support\Facades\Facade;

class JsonResponse extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'json';
    }
}

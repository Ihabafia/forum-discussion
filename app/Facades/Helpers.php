<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class Helpers extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'fd-helpers';
    }
}

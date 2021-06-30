<?php

namespace Nanuc\Nextcloud\Facades;

use Illuminate\Support\Facades\Facade;

class Nextcloud extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'nextcloud-api';
    }
}
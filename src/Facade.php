<?php

namespace NickDeKruijk\Oxxa;

class Facade extends \Illuminate\Support\Facades\Facade
{
    protected static function getFacadeAccessor()
    {
        return Oxxa::class;
    }
}

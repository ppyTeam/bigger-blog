<?php
/**
 * The Facade of Blog Settings.
 */

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class Setting extends Facade
{
    public static function getFacadeAccessor()
    {
        return 'BlogSetting';
    }

}
<?php
/**
 * The Facade of MarkDown Parser.
 */

namespace App\Facades;

use App\Helpers\MarkDownHelper;
use Illuminate\Support\Facades\Facade;

class MarkDown extends Facade
{
    public static function getFacadeAccessor()
    {
        return MarkDownHelper::class;
    }
}
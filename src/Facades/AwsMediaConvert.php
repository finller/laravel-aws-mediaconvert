<?php

namespace Finller\AwsMediaConvert\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Finller\AwsMediaConvert\AwsMediaConvert
 */
class AwsMediaConvert extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Finller\AwsMediaConvert\AwsMediaConvert::class;
    }
}

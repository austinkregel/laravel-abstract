<?php

use Kregel\LaravelAbstract\LaravelAbstract;

if (!function_exists('abstracted')) {
    function abstracted(): LaravelAbstract
    {
        return app()->make(LaravelAbstract::class);
    }
}
<?php

namespace Kregel\LaravelAbstract;

use Closure;

class LaravelAbstract
{
    /**
     * The middleware applied to the routes
     * @var string|array
     */
    public static $middlewareGroup = 'web';

    /**
     * Whether or not we should bypass the policies
     * @var bool
     */
    public static $bypassPolicies = false;

    /**
     * Set the specific the middleware that will be applied to the abstract routes.
     * @param string|array $middleware
     * @return static
     */
    public static function middleware($middleware)
    {
        static::$middlewareGroup = $middleware;

        return new static;
    }

    /**
     * Set whether or not we should just ignore the policies all together.
     * @param  bool  $bypass
     * @return LaravelAbstract
     */
    public static function bypass(bool $bypass = false)
    {
        static::$bypassPolicies = $bypass;

        return new static;
    }
}

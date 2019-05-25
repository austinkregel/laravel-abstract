<?php

namespace Kregel\LaravelAbstract;

use Closure;

class LaravelAbstract
{
    /**
     * The instace we use across the app
     * @var null|static
     */
    private static $instance = null;
    /**
     * The middleware applied to the routes
     * @var string|array
     */
    public $middlewareGroup = 'web';
    /**
     * Whether or not we should bypass the policies
     * @var bool
     */
    public $bypassPolicies = false;
    /**
     * The model-key => Model bindings for the dynamic routes.
     * @var array
     */
    public $routeBindings = [];
    /**
     * The indicator of whether or not we should declare the routes in the file.
     * @var bool
     */
    public $usingRoutes = true;
    /**
     * The way we resolve the abstract model
     * @var Closure
     */
    public $resolveModelsUsing;

    private function __construct()
    {
    }

    /**
     * @return LaravelAbstract
     */
    public static function bind(): LaravelAbstract
    {
        if (static::$instance == null) {
            static::$instance = new static;
        }

        return static::$instance;
    }


    /**
     * Set the specific the middleware that will be applied to the abstract routes.
     * @param  string|array  $middleware
     * @return static
     */
    public function middleware($middleware): LaravelAbstract
    {
        $this->middlewareGroup = $middleware;

        return $this;
    }

    /**
     * Set whether or not we should just ignore the policies all together.
     * @param  bool  $bypass
     * @return LaravelAbstract
     */
    public function bypass(bool $bypass = false): LaravelAbstract
    {
        $this->bypassPolicies = $bypass;

        return $this;
    }

    /**
     * @param  array|string  $modelOrModels
     * @return string|static
     */
    public function route($modelOrModels = [])
    {
        if (is_string($modelOrModels)) {
            return $this->routeBindings[$modelOrModels];
        }

        $this->routeBindings = $modelOrModels;

        return $this;
    }

    /**
     * Set whether or not we will use the abstracted routes.
     * @param  bool  $useRoutes
     * @return LaravelAbstract
     */
    public function useRoutes(bool $useRoutes = false): LaravelAbstract
    {
        $this->usingRoutes = $useRoutes;

        return $this;
    }

    /**
     * Change the way the package tries to resolve the eloquent models from the URI
     * @param  Closure  $closure
     * @return LaravelAbstract
     */
    public function resolveUsing(Closure $closure): LaravelAbstract
    {
        $this->resolveModelsUsing = $closure;

        return $this;
    }
}

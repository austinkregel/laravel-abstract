<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Kregel\LaravelAbstract\AbstractEloquentModel;
use Kregel\LaravelAbstract\Exceptions\ModelNotInstanceOfAbstractEloquentModel;
use Kregel\LaravelAbstract\LaravelAbstract;

class AbstractRouteServiceProvider extends ServiceProvider
{
    public const ROUTE_BINDINGS = [];

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        LaravelAbstract::middleware([
            'web', 'auth'
        ]);

        Route::bind('abstract_model', function ($value) {
            $class = static::ROUTE_BINDINGS[$value];

            $model = new $class;

            throw_if(!$model instanceof AbstractEloquentModel, ModelNotInstanceOfAbstractEloquentModel::class);

            return $model;
        });

        Request::macro('abstract_model', function () {
            return $this->route('abstract_model');
        });
    }

    public function map()
    {
        Route::middleware(LaravelAbstract::$middlewareGroup)
            ->namespace('Kregel\LaravelAbstract\Http\Controllers')
            ->group(function () {
                Route::get('api/{abstract_model}', 'AbstractResourceController@index');
                Route::post('api/{abstract_model}', 'AbstractResourceController@store');
                Route::get('api/{abstract_model}/{id}', 'AbstractResourceController@show');
                Route::put('api/{abstract_model}/{id}', 'AbstractResourceController@update');
                Route::patch('api/{abstract_model}/{id}', 'AbstractResourceController@update');
                Route::delete('api/{abstract_model}/{id}', 'AbstractResourceController@destroy');
            });
    }
}

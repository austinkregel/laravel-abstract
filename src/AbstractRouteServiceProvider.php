<?php

namespace App\Providers;

use App\User;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;
use Kregel\LaravelAbstract\AbstractEloquentModel;
use Kregel\LaravelAbstract\Exceptions\ModelNotInstanceOfAbstractEloquentModel;
use Kregel\LaravelAbstract\LaravelAbstract;

class AbstractRouteServiceProvider extends ServiceProvider
{
    public function boot()
    {
        parent::boot();

        LaravelAbstract::bind()
            ->middleware(['web', 'auth'])
            ->route([
                'users' => User::class
            ]);

        Route::bind('abstract_model', LaravelAbstract::bind()->resolveModelsUsing ?? function ($value) {
                $class = LaravelAbstract::bind()->route($value);

                $model = new $class;

                throw_if(!$model instanceof AbstractEloquentModel, ModelNotInstanceOfAbstractEloquentModel::class);

                return $model;
            });
    }

    public function map()
    {
        if (LaravelAbstract::bind()->usingRoutes) {
            $this->mapRoutes();
        }
    }

    protected function mapRoutes()
    {
        Route::middleware(LaravelAbstract::bind()->middlewareGroup)
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

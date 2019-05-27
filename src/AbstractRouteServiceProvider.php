<?php

namespace App\Providers;

use App\User;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;
use Kregel\LaravelAbstract\AbstractEloquentModel;
use Kregel\LaravelAbstract\Exceptions\ModelNotInstanceOfAbstractEloquentModel;

class AbstractRouteServiceProvider extends ServiceProvider
{
    public function boot()
    {
        parent::boot();

        abstracted()
            ->middleware(['web', 'auth'])
            ->route([
                'users' => User::class
            ]);

        Route::bind('abstract_model', abstracted()->resolveModelsUsing ?? function ($value) {
            $class = abstracted()->route($value);

            $model = new $class;

            throw_if(!$model instanceof AbstractEloquentModel, ModelNotInstanceOfAbstractEloquentModel::class);

            return $model;
        });
    }

    public function map()
    {
        if (abstracted()->usingRoutes) {
            $this->mapRoutes();
        }
    }

    protected function mapRoutes()
    {
        Route::middleware(abstracted()->middlewareGroup)
            ->namespace('Kregel\LaravelAbstract\Http\Controllers')
            ->group(function () {
                Route::get('api/{abstract_model}', 'AbstractResourceController@index');
                Route::post('api/{abstract_model}', 'AbstractResourceController@store');
                Route::get('api/{abstract_model}/{id}', 'AbstractResourceController@show');
                // Updating
                Route::put('api/{abstract_model}/{id}', 'AbstractResourceController@update');
                Route::patch('api/{abstract_model}/{id}', 'AbstractResourceController@update');
                // Restoring
                Route::post('api/{abstract_model}/{id}/restore', 'AbstractResourceController@restore');
                // Soft-deleting
                Route::delete('api/{abstract_model}/{id}', 'AbstractResourceController@destroy');
                // Force delete
                Route::delete('api/{abstract_model}/{id}/force', 'AbstractResourceController@forceDestroy');
            });
    }
}

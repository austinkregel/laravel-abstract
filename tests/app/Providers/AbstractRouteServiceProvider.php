<?php

namespace App\Providers;

use App\ForceUser;
use App\User;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;
use Kregel\LaravelAbstract\AbstractEloquentModel;
use Kregel\LaravelAbstract\Exceptions\ModelNotInstanceOfAbstractEloquentModel;

class AbstractRouteServiceProvider extends ServiceProvider
{
    public function boot()
    {
        abstracted()
            ->middleware(['web', 'auth'])
            ->route([
                'users' => User::class,
                'force_users' => ForceUser::class,
            ]);

        Route::bind('abstract_model', abstracted()->resolveModelsUsing ?? function ($value) {
            $class = abstracted()->route($value);

            $model = new $class;

            throw_if(!$model instanceof AbstractEloquentModel, ModelNotInstanceOfAbstractEloquentModel::class);

            return $model;
        });

        Route::bind('abstract_model_id', function ($id) {
            /** @var AbstractEloquentModel $model */
            $model = request()->route('abstract_model');
            $query = $model->query();

            if ($model->usesSoftdeletes()) {
                /** @var SoftDeletes $query */
                $query->withTrashed();
            }

            $value = $query->find($id);
            return $value ?? abort(404);
        });

        parent::boot();
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
            ->group(function (Router $router) {
                $router->get("api/{abstract_model}", "AbstractResourceController@index")->name('api.abstract.index');
                $router->post("api/{abstract_model}", "AbstractResourceController@store")->name('api.abstract.store');
                $router->get("api/{abstract_model}/{abstract_model_id}", "AbstractResourceController@show")->name('api.abstract.show');
                // Updating
                $router->put("api/{abstract_model}/{abstract_model_id}", "AbstractResourceController@update")->name('api.abstract.update');
                $router->patch("api/{abstract_model}/{abstract_model_id}", "AbstractResourceController@update")->name('api.abstract.update');
                // Restoring
                $router->post("api/{abstract_model}/{abstract_model_id}/restore", "AbstractResourceController@restore")->name('api.abstract.restore');
                // Soft-deleting
                $router->delete("api/{abstract_model}/{abstract_model_id}", "AbstractResourceController@destroy")->name('api.abstract.destroy');
                // Force delete
                $router->delete("api/{abstract_model}/{abstract_model_id}/force", "AbstractResourceController@forceDestroy")->name('api.abstract.forceDestroy');
            });
    }
}

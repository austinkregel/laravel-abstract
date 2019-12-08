<?php

namespace Kregel\LaravelAbstract\Http\Controllers;

use Exception;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller;
use Kregel\LaravelAbstract\AbstractEloquentModel;
use Kregel\LaravelAbstract\Filters\ActionFilter;
use Kregel\LaravelAbstract\Http\Requests\CreateRequest;
use Kregel\LaravelAbstract\Http\Requests\DeleteRequest;
use Kregel\LaravelAbstract\Http\Requests\ForceDeleteRequest;
use Kregel\LaravelAbstract\Http\Requests\IndexRequest;
use Kregel\LaravelAbstract\Http\Requests\RestoreRequest;
use Kregel\LaravelAbstract\Http\Requests\UpdateRequest;
use Kregel\LaravelAbstract\Http\Requests\ViewRequest;
use Spatie\QueryBuilder\AllowedFilter as Filter;
use Spatie\QueryBuilder\QueryBuilder;

class AbstractResourceController extends Controller
{
    use AuthorizesRequests, ValidatesRequests;

    /**
     * @throws Exception
     */
    public function index(IndexRequest $request, AbstractEloquentModel $model)
    {
        $action = new ActionFilter(request()->get('action', 'paginate:14'));

        $query = QueryBuilder::for(get_class($model))
            ->allowedFields($model->getAbstractAllowedFields())
            ->allowedFilters(array_merge($model->getAbstractAllowedFilters(), [
                Filter::scope('q')
            ]))
            ->allowedIncludes($model->getAbstractAllowedRelationships())
            ->allowedSorts($model->getAbstractAllowedSorts());

        return $action->execute($query);
    }

    public function store(CreateRequest $request, AbstractEloquentModel $model)
    {
        /** @var AbstractEloquentModel $resource */
        $resource = new $model;
        $resource->fill($request->validated());
        $resource->save();
        return $resource->refresh();
    }

    public function show(ViewRequest $request, AbstractEloquentModel $model, AbstractEloquentModel $abstractEloquentModel)
    {
        $query = QueryBuilder::for(get_class($model))
            ->allowedFields($model->getAbstractAllowedFields())
            ->allowedFilters($model->getAbstractAllowedFilters())
            ->allowedIncludes($model->getAbstractAllowedRelationships())
            ->allowedSorts($model->getAbstractAllowedSorts());

        return $query->find($abstractEloquentModel->id) ?? response([
                'message' => 'No resource found by that id.'
            ], 404);
    }

    public function update(UpdateRequest $request, AbstractEloquentModel $model, AbstractEloquentModel $abstractEloquentModel)
    {
        $abstractEloquentModel->update($request->all());

        return $abstractEloquentModel->refresh();
    }

    public function destroy(DeleteRequest $request, AbstractEloquentModel $model, AbstractEloquentModel $abstractEloquentModel)
    {
        $abstractEloquentModel->delete();

        return response('', 204);
    }

    public function forceDestroy(ForceDeleteRequest $request, AbstractEloquentModel $model, AbstractEloquentModel $abstractEloquentModel)
    {
        if (!$model->usesSoftdeletes()) {
            abort(404, "You cannot force delete an item of this type.");
            return;
        }

        $abstractEloquentModel->forceDelete();

        return response('', 204);
    }

    public function restore(RestoreRequest $request, AbstractEloquentModel $model, AbstractEloquentModel $abstractEloquentModel)
    {
        if (!$model->usesSoftdeletes()) {
            abort(404, "You cannot restore an item of this type.");
            return;
        }

        $abstractEloquentModel->restore();

        return $abstractEloquentModel->refresh();
    }
}

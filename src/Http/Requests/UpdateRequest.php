<?php

namespace Kregel\LaravelAbstract\Http\Requests;

use Kregel\LaravelAbstract\AbstractEloquentModel;
use Illuminate\Foundation\Http\FormRequest;
use Kregel\LaravelAbstract\LaravelAbstract;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class UpdateRequest extends FormRequest
{
    public function authorize()
    {
        if (LaravelAbstract::bind()->bypassPolicies === true) {
            return true;
        }

        $id = $this->route('id');

        /** @var AbstractEloquentModel $model */
        $model = $this->route('abstract_model');

        throw_unless($item = $model::find($id), NotFoundHttpException::class);

        return $this->user()->can('create', $item);
    }

    public function rules()
    {
        /** @var AbstractEloquentModel $model */
        $model = $this->route('abstract_model');
        return $model::VALIDATION_UPDATE_RULES;
    }
}

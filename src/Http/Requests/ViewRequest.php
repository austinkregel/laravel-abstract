<?php

namespace Kregel\LaravelAbstract\Http\Requests;

use Kregel\LaravelAbstract\AbstractEloquentModel;
use Illuminate\Foundation\Http\FormRequest;
use Kregel\LaravelAbstract\LaravelAbstract;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ViewRequest extends FormRequest
{
    public function authorize()
    {
        if (abstracted()->bypassPolicies === true) {
            return true;
        }

        $modelId = $this->route('abstract_model_id');

        throw_unless($modelId->id, NotFoundHttpException::class);

        return $this->user()->can('view', $modelId);
    }

    public function rules()
    {
        /** @var AbstractEloquentModel $model */
        $model = $this->route('abstract_model');
        return $model::VALIDATION_UPDATE_RULES;
    }
}

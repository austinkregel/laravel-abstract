<?php

namespace Kregel\LaravelAbstract\Http\Requests;

use Kregel\LaravelAbstract\AbstractEloquentModel;
use Illuminate\Foundation\Http\FormRequest;

class CreateRequest extends FormRequest
{
    public function authorize()
    {
        if (abstracted()->bypassPolicies === true) {
            return true;
        }

        /** @var AbstractEloquentModel $model */
        $model = $this->route('abstract_model');

        return $this->user()->can('create', get_class($model));
    }

    public function rules()
    {
        /** @var AbstractEloquentModel $model */
        $model = $this->route('abstract_model');
        return $model->getValidationCreateRules();
    }
}

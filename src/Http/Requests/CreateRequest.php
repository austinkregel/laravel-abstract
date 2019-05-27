<?php

namespace Kregel\LaravelAbstract\Http\Requests;

use Kregel\LaravelAbstract\AbstractEloquentModel;
use Illuminate\Foundation\Http\FormRequest;

class CreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if (abstracted()->bypassPolicies === true) {
            return true;
        }

        /** @var AbstractEloquentModel $model */
        $model = $this->route('abstract_model');

        return $this->user()->can('create', get_class($model));
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        /** @var AbstractEloquentModel $model */
        $model = $this->route('abstract_model');
        return $model::VALIDATION_CREATE_RULES;
    }
}

<?php

namespace Kregel\LaravelAbstract\Http\Requests;

use Kregel\LaravelAbstract\AbstractEloquentModel;
use Illuminate\Foundation\Http\FormRequest;

class IndexRequest extends FormRequest
{
    public function authorize(): bool
    {
        if (abstracted()->bypassPolicies === true) {
            return true;
        }

        /** @var AbstractEloquentModel $model */
        $model = $this->route('abstract_model');

        return $this->user()->can('index', get_class($model));
    }

    public function rules(): array
    {
        return [];
    }
}

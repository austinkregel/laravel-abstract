<?php

namespace Kregel\LaravelAbstract\Http\Requests;

use Kregel\LaravelAbstract\AbstractEloquentModel;
use Illuminate\Foundation\Http\FormRequest;
use Kregel\LaravelAbstract\LaravelAbstract;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class DeleteRequest extends FormRequest
{
    public function authorize(): bool
    {
        if (abstracted()->bypassPolicies === true) {
            return true;
        }

        $modelId = $this->route('abstract_model_id');

        throw_unless($modelId->id, NotFoundHttpException::class);

        return $this->user()->can('delete', $modelId);
    }

    public function rules(): array
    {
        return [];
    }
}

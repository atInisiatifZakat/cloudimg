<?php

declare(strict_types=1);

namespace FromHome\Cloudimg\Http\Requests;

use FromHome\Cloudimg\Enums\Provider;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

final class CreateOrUpdateSourceRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => 'required|string',
            'domain' => 'required|unique:sources,domain',
            'provider' => 'required|in:' . \implode(',', Provider::values()),
            'is_active' => 'required|boolean',
        ];
    }

    protected function getValidatorInstance(): Validator
    {
        $v = parent::getValidatorInstance();

        $v->sometimes([
            'provider_key',
            'provider_secret',
            'aws_region',
            'aws_bucket',
            'aws_end_point',
        ], 'required', fn () => Provider::AWS() === $this->input('provider'));

        return $v;
    }
}

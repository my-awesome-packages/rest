<?php

namespace Awesome\Rest\Requests;

abstract class FilledIdsRequest extends AbstractFormRequest
{
    public function rules(): array
    {
        return [
            'ids' => 'filled|array',
            'ids.*' => 'required|uuid',
        ];
    }
}

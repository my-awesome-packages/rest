<?php

namespace Awesome\Rest\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Awesome\Foundation\Traits\Resources\Resourceable;

class SuccessResource extends JsonResource
{
    use Resourceable;

    public function toArray($request = null): array
    {
        return [
            'success' => $this->bool($this->resource['success'])
        ];
    }
}

<?php

namespace Awesome\Rest\Macros;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Response as ResponseFactory;

class ResponseMacros
{
    public static function jsonResponse()
    {
        ResponseFactory::macro(
            'jsonResponse',
            function (
                $data = null,
                $errorCode = null,
                $errorMessage = null,
                $status = 200,
                $headers = [],
                $options = 0
            ) {
                $hasError = !is_null($errorCode);
                if ($hasError) {
                    $content = [
                        'error_code' => $errorCode,
                        'error_message' => $errorMessage ?? trans('awesome-rest::error.default'),
                        'error_data' => $data ? $data : null
                    ];
                } else {
                    $content = $data;
                }

                return ResponseFactory::json(
                    [
                        'error' => $hasError ? 1 : 0,
                        'content' => $content
                    ],
                    $status,
                    $headers,
                    $options
                );
            }
        );

        Response::macro('isJsonType', function () {
            return Str::contains($this->headers->get('Content-Type'), 'application/json');
        });

        Response::macro('hasError', function ($data) {
            return Arr::get($data ?? [], 'error', 1) === 1;
        });

        Response::macro('decode', function () {
            try {
                if ($this->isJsonType()) {
                    return json_decode($this->content(), true);
                }
            } catch (\Exception $e) {
                return null;
            }
        });
    }
}

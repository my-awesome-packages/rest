<?php

namespace Awesome\Rest\Macros;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;

class RequestMacros
{
    public static function registerRequestValidation()
    {
        Request::macro('validate', function (array $rules, ...$params) {
            return validator()->validate($this->all(), $rules, ...$params);
        });
    }

    public static function registerRequestSignatureValidation()
    {
        Request::macro('hasValidSignature', function ($absolute = true) {
            return URL::hasValidSignature($this, $absolute);
        });
    }

    public static function registerRequestRealIp()
    {
        Request::macro('realIp', function () {
            return app('request')->server('HTTP_X_REAL_IP');
        });
    }
}

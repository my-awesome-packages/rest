<?php

namespace Awesome\Rest;

use Awesome\Rest\Macros\RequestMacros;
use Awesome\Rest\Macros\ResponseMacros;
use Illuminate\Support\ServiceProvider;
use Awesome\Rest\Requests\AbstractFormRequest;
use Illuminate\Contracts\Validation\ValidatesWhenResolved;

class RestProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadTranslationsFrom(__DIR__.'/lang', 'awesome-rest');

        $this->app->afterResolving(ValidatesWhenResolved::class, function ($resolved) {
            $resolved->validateResolved();
        });

        $this->app->resolving(AbstractFormRequest::class, function ($request, $app) {
            $request = AbstractFormRequest::createFrom($app['request'], $request);
            $request->setContainer($app);
        });
    }

    public function register()
    {
        parent::register();
        ResponseMacros::jsonResponse();
        RequestMacros::registerRequestRealIp();
        RequestMacros::registerRequestValidation();
        RequestMacros::registerRequestSignatureValidation();
    }

    public function provides()
    {
        return [];
    }
}

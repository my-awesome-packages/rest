<?php

namespace Awesome\Rest\Exceptions;

abstract class AbstractException extends \Exception
{
    const SYMBOLIC_CODE = "internal_error";
    const NUMERIC_CODE = 0;

    private $data = null;

    public function __construct($data = null, int $code = 0, \Throwable $previous = null)
    {
        $this->data = $data;
        $code = $code ?: static::NUMERIC_CODE;

        parent::__construct(
            trans('awesome-rest::errors.exceptions.' . $this->getMessageCode()),
            $code,
            $previous
        );
    }

    public function report()
    {
        try {
            $logger = app('Psr\Log\LoggerInterface');
        } catch (\Exception $ex) {
            throw $this; // throw the original exception
        }

        $logger->warning($this, [
            'exception' => $this,
            'message_data' => $this->getMessageData(),
            'code_exception' => static::SYMBOLIC_CODE
        ]);
    }

    public function getMessageData()
    {
        return $this->data;
    }

    public function getMessageCode()
    {
        return static::SYMBOLIC_CODE;
    }
}

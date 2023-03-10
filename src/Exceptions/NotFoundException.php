<?php

namespace Talently\FeatureFlags\Exceptions;

use Talently\FeatureFlags\Data\Constants\ExceptionCode;

class NotFoundException extends \DomainException
{

    public function __construct($message = "n", $code = ExceptionCode::NOT_FOUND, \Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
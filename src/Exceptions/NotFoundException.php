<?php

namespace Talently\FeatureFlags\Exceptions;

use Talently\FeatureFlags\Data\Constants\ExceptionCode;

/**
 *
 */
class NotFoundException extends \DomainException
{

    /**
     * @param string $message
     * @param int $code
     * @param \Throwable|null $previous
     */
    public function __construct(string $message = "Not found", int $code = ExceptionCode::NOT_FOUND, \Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
<?php

namespace App\Exceptions;

use Illuminate\Auth\Access\AuthorizationException;
use Throwable;

class NotAllowReportException extends AuthorizationException
{
    public function __construct($message = "请先到迎新服务台登记后，再次重试！", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}

<?php
namespace App\Exceptions;

use Lang;
use Symfony\Component\HttpKernel\Exception\HttpException;

class LoginFailed extends HttpException
{
    private $error;

    public function __construct($error, $statusCode = 403)
    {
        $this->error = $error;
        parent::__construct($statusCode, Lang::get('auth.failed'), null, [], $statusCode);
    }

    public function getError()
    {
        return $this->error;
    }
}

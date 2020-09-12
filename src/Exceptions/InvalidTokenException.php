<?php

namespace AdamTyn\AT\JWT\Exceptions;

use \Exception;

class InvalidTokenException extends Exception
{
    protected $code = '50000';

    protected $message = 'Invalid Token.';
}
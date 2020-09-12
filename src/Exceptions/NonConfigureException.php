<?php

namespace AdamTyn\AT\JWT\Exceptions;

use \Exception;

class NonConfigureException extends Exception
{
    protected $code = '51000';

    protected $message = 'Configure File Not Exists.';
}
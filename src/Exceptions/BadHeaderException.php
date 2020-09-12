<?php

namespace AdamTyn\AT\JWT\Exceptions;

class BadHeaderException extends InvalidTokenException
{
    protected $code = '50010';

    protected $message = 'Bad Header.';
}
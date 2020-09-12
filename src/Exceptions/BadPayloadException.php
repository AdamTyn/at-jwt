<?php

namespace AdamTyn\AT\JWT\Exceptions;

class BadPayloadException extends InvalidTokenException
{
    protected $code = '50020';

    protected $message = 'Bad Payload.';
}
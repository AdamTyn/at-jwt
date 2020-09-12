<?php

namespace AdamTyn\AT\JWT\Exceptions;

final class InvalidDefaultPayloadException extends BadPayloadException
{
    protected $code = '50021';

    protected $message = 'Invalid DefaultPayload.';
}
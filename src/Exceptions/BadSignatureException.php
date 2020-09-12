<?php

namespace AdamTyn\AT\JWT\Exceptions;

final class BadSignatureException extends InvalidTokenException
{
    protected $code = '50002';

    protected $message = 'Bad Signature.';
}
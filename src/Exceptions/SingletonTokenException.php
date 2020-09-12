<?php

namespace AdamTyn\AT\JWT\Exceptions;

final class SingletonTokenException extends InvalidTokenException
{
    protected $code = '50001';

    protected $message = 'Singleton Token Cannot Be Refreshed.';
}
<?php

namespace AdamTyn\AT\JWT\Exceptions;

final class DifferentAlgorithmException extends BadHeaderException
{
    protected $code = '50011';

    protected $message = 'Header`s Algorithm and Payload`s Algorithm Must Be The Same.';
}
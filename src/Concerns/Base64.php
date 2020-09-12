<?php

namespace AdamTyn\AT\JWT\Concerns;

trait Base64
{
    /**
     * @var bool
     */
    protected $done = false;

    /**
     * @var string
     */
    protected $base64 = '';

    /**
     * @return bool
     */
    public function isDone()
    {
        return $this->done;
    }
}
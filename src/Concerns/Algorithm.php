<?php

namespace AdamTyn\AT\JWT\Concerns;

use AdamTyn\AT\JWT\HS256;

trait Algorithm
{
    /**
     * @var HS256
     */
    protected $algorithm;

    /**
     * @return HS256
     */
    public function getAlgorithm()
    {
        return $this->algorithm;
    }
}
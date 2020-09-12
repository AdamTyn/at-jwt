<?php

use AdamTyn\AT\JWT\Config;
use PHPUnit\Framework\TestCase;

class ConfigTest extends TestCase
{
    public function testGetValue()
    {
        $value = Config::getValue('REDIS_HOST');

        _print($value);

        $this->assertNotNull($value);

        return $value;
    }
}
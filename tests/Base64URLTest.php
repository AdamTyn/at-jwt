<?php

use AdamTyn\AT\JWT\Base64URL;
use PHPUnit\Framework\TestCase;

class Base64URLTest extends TestCase
{
    public function testEncode()
    {
        $origin = 'http://www.baidu.com/path=home?t=123';

        _print($origin);

        $afterEncode = Base64URL::encode($origin);

        _print($afterEncode);

        $this->assertIsString($afterEncode);

        return $afterEncode;
    }

    /**
     * @depends testEncode
     *
     * @param string $afterEncode
     */
    public function testDecode(string $afterEncode)
    {
        $origin = 'http://www.baidu.com/path=home?t=123';

        $afterDecode = Base64URL::decode($afterEncode);

        _print($afterDecode);

        $this->assertEquals($origin, $afterDecode);
    }
}
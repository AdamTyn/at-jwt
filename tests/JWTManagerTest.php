<?php

use AdamTyn\AT\JWT\{JWT, JWTManager};
use PHPUnit\Framework\TestCase;

class JWTManagerTest extends TestCase
{
    public function testClaim()
    {
        $claim = [
            'version' => 'v1.0.0',
            'app_name' => 'at-jwt'
        ];

        $this->assertIsArray($claim);

        return $claim;
    }

    /**
     * @depends testClaim
     *
     * @param array $claim
     * @return string
     */
    public function testGetToken(array $claim)
    {
        $token = JWTManager::getToken($claim);

        $this->assertInstanceOf(JWT::class, $token);

        return strval($token);
    }

    /**
     * @depends testGetToken
     *
     * @param string $token
     * @return JWT
     */
    public function testGenerate(string $token)
    {
        _print($token);

        $afterGenerate = JWTManager::generate($token);

        $this->assertInstanceOf(JWT::class, $afterGenerate);

        _print($afterGenerate);

        $this->assertEquals($token, strval($afterGenerate));

        return $afterGenerate;
    }

    /**
     * @depends testGetToken
     *
     * @param string $token
     */
    public function testRefresh(string $token)
    {
        $afterRefresh = JWTManager::refresh($token);

        $this->assertInstanceOf(JWT::class, $afterRefresh);

        _print($afterRefresh);

        $this->assertNotEquals($token, strval($afterRefresh));
    }
}
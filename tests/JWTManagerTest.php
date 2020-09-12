<?php

use AdamTyn\AT\JWT\{JWT, JWTManager};
use AdamTyn\AT\JWT\Contracts\SubjectInterface;
use PHPUnit\Framework\TestCase;

class JWTManagerTest extends TestCase
{
    public function testSubject()
    {
        $subject = new class implements SubjectInterface {
            public function getClaim(): array
            {
                return [
                    'version' => 'v1.0.0',
                    'app_name' => 'at-jwt'
                ];
            }

            public function setClaim(array $claim)
            {
                // TODO: Implement setClaim() method.
            }
        };

        $this->assertInstanceOf(SubjectInterface::class, $subject);

        return $subject;
    }

    /**
     * @depends testSubject
     *
     * @param SubjectInterface $subject
     * @return string
     */
    public function testGetToken(SubjectInterface $subject)
    {
        $token = JWTManager::getToken($subject);

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
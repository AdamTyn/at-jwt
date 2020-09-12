<?php

namespace AdamTyn\AT\JWT;

use AdamTyn\AT\JWT\Exceptions\{
    BadSignatureException,
    InvalidTokenException
};
use AdamTyn\AT\JWT\Contracts\SubjectInterface as Subject;

class JWTManager
{
    /**
     * @param Subject $subject
     * @param bool $singleton
     * @param int $ttl
     * @return JWT
     */
    public static function getToken(Subject $subject, bool $singleton = false, int $ttl = 0)
    {
        $jwt = new JWT;

        return $jwt->withClaim($subject)->singleton($singleton)->ttl($ttl);
    }

    /**
     * @param string $token
     * @return JWT
     *
     * @throws BadSignatureException
     * @throws Exceptions\BadHeaderException
     * @throws Exceptions\BadPayloadException
     * @throws Exceptions\DifferentAlgorithmException
     * @throws Exceptions\InvalidDefaultPayloadException
     * @throws InvalidTokenException
     */
    public static function generate(string $token)
    {
        $param = explode('.', trim($token));

        if (count($param) !== 3) {
            throw new InvalidTokenException;
        }

        list($header, $payload, $signature) = $param;

        $header = Header::generate($header);

        $payload = Payload::generate($header, $payload);

        $jwt = (new JWT)->withHeader($header)->withPayload($payload);

        if ($jwt->sign(strval($header), strval($payload)) !== $signature) {
            throw new BadSignatureException;
        }

        return $jwt;
    }

    /**
     * @param string $token
     * @return bool
     *
     * @throws Exceptions\BadSignatureException
     * @throws Exceptions\BadHeaderException
     * @throws Exceptions\BadPayloadException
     * @throws Exceptions\DifferentAlgorithmException
     * @throws Exceptions\InvalidDefaultPayloadException
     * @throws InvalidTokenException
     */
    public static function expired(string $token)
    {
        $jwt = self::generate($token);

        return $jwt->getPayload()->expired();
    }

    /**
     * @param string $token
     * @param bool $terminate
     * @param int $moreTtl
     * @return JWT
     *
     * @throws Exceptions\BadSignatureException
     * @throws Exceptions\BadHeaderException
     * @throws Exceptions\BadPayloadException
     * @throws Exceptions\DifferentAlgorithmException
     * @throws Exceptions\InvalidDefaultPayloadException
     * @throws InvalidTokenException
     */
    public static function refresh(string $token, bool $terminate = false, int $moreTtl = 0)
    {
        $jwt = self::generate($token);

        return $jwt->refresh($terminate, $moreTtl);
    }
}
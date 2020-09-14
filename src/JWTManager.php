<?php

namespace AdamTyn\AT\JWT;

use AdamTyn\AT\JWT\Exceptions\{
    BadSignatureException,
    InvalidTokenException
};

class JWTManager
{
    /**
     * @param array $payload
     * @param array $header
     * @return JWT
     */
    public static function getToken(array $payload, array $header = [])
    {
        $jwt = new JWT;

        return $jwt->withClaim($payload)->withExtra($header);
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

        $jwt = (new JWT)->setHeader($header)->setPayload($payload);

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
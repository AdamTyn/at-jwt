<?php

namespace AdamTyn\AT\JWT;

final class HS256
{
    /**
     * @var string
     */
    protected static $algorithm = 'sha256';

    /**
     * @var string
     */
    protected static $name = 'HS256';

    /**
     * @param string $data
     * @return string
     */
    public function transport(string $data)
    {
        $after = hash_hmac(self::$algorithm, $data, self::getSecret());

        if (is_bool($after)) {
            $after = '';
        }

        return $after;
    }

    /**
     * @return string
     */
    public function name()
    {
        return self::$name;
    }

    /**
     * @return string
     */
    private static function getSecret(): string
    {
        return Config::getValue('AT_JWT_SECRET');
    }
}
<?php

namespace AdamTyn\AT\JWT;

final class Base64URL
{
    /**
     * @param string $after
     * @return string
     */
    public static function decode(string $after)
    {
        $decoded = str_replace(['-', '_'], ['+', '/'], $after);

        $mod4 = strlen($decoded) % 4;

        if ($mod4) {
            $decoded .= substr('====', $mod4);
        }

        return base64_decode($decoded);
    }

    /**
     * @param string $before
     * @return string
     */
    public static function encode(string $before)
    {
        $encoded = base64_encode($before);

        $encoded = str_replace(['+', '/', '='], ['-', '_', ''], $encoded);

        return $encoded;
    }
}
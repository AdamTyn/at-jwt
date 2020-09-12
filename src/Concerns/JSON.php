<?php

namespace AdamTyn\AT\JWT\Concerns;

trait JSON
{
    /**
     * @param $before
     * @return string
     */
    public static function jsonEncode($before)
    {
        $after = json_encode($before, JSON_UNESCAPED_UNICODE + JSON_UNESCAPED_SLASHES);

        if (is_bool($after)) {
            $after = '';
        }

        return $after;
    }

    /**
     * @param string $after
     * @return mixed
     */
    public static function jsonDecode(string $after)
    {
        $before = json_decode($after, true);

        if (!is_array($before)) {
            $before = [];
        }

        return $before;
    }
}
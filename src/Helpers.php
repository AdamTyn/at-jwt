<?php

if (!function_exists('root_path')) {
    function root_path(string $fileName = '')
    {
        $divide = DIRECTORY_SEPARATOR;
        $path = __DIR__;

        $temp = explode($divide, $path);
        $result = '';
        $count = count($temp);

        for ($i = 0; $i < $count - 4; ++$i) {
            $result .= ($temp[$i] . $divide);
        }

        $fileName = trim($fileName);

        return $result . $fileName;
    }
}

if (!function_exists('_print')) {
    function _print(string $message)
    {
        fwrite(STDOUT, $message . PHP_EOL);
    }
}
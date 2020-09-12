<?php

namespace AdamTyn\AT\JWT;

use AdamTyn\AT\JWT\Exceptions\BadHeaderException;
use AdamTyn\AT\JWT\Concerns\{Algorithm, Base64, JSON};

class Header
{
    use JSON, Base64, Algorithm;

    /**
     * @var string
     */
    protected static $type = 'JWT';

    /**
     * @var array
     */
    protected $extra = [];

    /**
     * Header constructor.
     */
    public function __construct()
    {
        $this->algorithm = new HS256;
    }

    /**
     * @param array $data
     * @return Header
     */
    public function setExtra(array $data)
    {
        $this->extra = $data + $this->extra;

        $this->done = false;

        return $this;
    }

    /**
     * @return string
     */
    public function make()
    {
        if (!$this->isDone()) {
            $data = ['algorithm' => $this->algorithm->name(), 'type' => self::$type, 'extra' => $this->extra];

            $this->base64 = Base64URL::encode(self::jsonEncode($data));

            $this->done = true;
        }

        return $this->base64;
    }

    /**
     * @param string $header
     * @return Header
     *
     * @throws BadHeaderException
     */
    public static function generate(string $header)
    {
        $data = Base64URL::decode($header);

        if (is_bool($data)) {
            throw new BadHeaderException;
        }

        $data = self::jsonDecode($data);

        list('extra' => $extra) = $data;

        return (new self)->setExtra($extra);
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->make();
    }
}
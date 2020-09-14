<?php

namespace AdamTyn\AT\JWT;

use AdamTyn\AT\JWT\Contracts\Renderable;
use AdamTyn\AT\JWT\Exceptions\BadHeaderException;
use AdamTyn\AT\JWT\Concerns\{Algorithm, Base64, JSON};

class Header implements Renderable
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
     * @param array $extra
     * @return Header
     */
    public function setExtra(array $extra)
    {
        if (count($extra) > 0) {
            $this->extra = $extra + $this->extra;

            $this->done = false;
        }

        return $this;
    }

    /**
     * @return array
     */
    public function getExtra()
    {
        return $this->extra;
    }

    /**
     * @return string
     */
    public function render()
    {
        if (!$this->isDone()) {
            $data = [
                'algorithm' => $this->algorithm->name(),
                'type' => self::$type,
                'extra' => $this->extra
            ];

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

        return (new self)->setExtra($data['extra'] ?? []);
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->render();
    }
}
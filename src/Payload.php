<?php

namespace AdamTyn\AT\JWT;

use AdamTyn\AT\JWT\Exceptions\{
    InvalidDefaultPayloadException,
    SingletonTokenException,
    BadPayloadException
};
use AdamTyn\AT\JWT\Concerns\{Algorithm, Base64, JSON};
use AdamTyn\AT\JWT\Contracts\SubjectInterface as Subject;

class Payload
{
    use JSON, Base64, Algorithm;

    /**
     * @var DefaultPayload
     */
    protected $default;

    /**
     * @var Subject
     */
    protected $subject;

    /**
     * Payload constructor.
     * @param HS256 $algorithm
     */
    public function __construct(HS256 $algorithm)
    {
        $this->algorithm = $algorithm;

        $this->default = new DefaultPayload;

        $this->subject = new DefaultSubject;
    }

    /**
     * @param string $serialized
     * @return Payload
     * @throws InvalidDefaultPayloadException
     */
    public function setDefault(string $serialized)
    {
        $default = unserialize($serialized);

        if (is_bool($default) || !($default instanceof DefaultPayload)) {
            throw new InvalidDefaultPayloadException;
        }

        $this->default = $default;

        $this->done = false;

        return $this;
    }

    /**
     * @param array $claim
     * @return Payload
     */
    public function setSubject(array $claim)
    {
        $this->subject->setClaim($claim);

        $this->done = false;

        return $this;
    }

    public function singleton(bool $open)
    {
        $this->default->singleton = $open;

        $this->done = false;

        return $this;
    }

    /**
     * @param int $seconds
     * @return Payload
     */
    public function ttl(int $seconds)
    {
        if ($seconds > 0) {
            $this->default->expired = $seconds;

            $this->done = false;
        }

        return $this;
    }

    /**
     * @return string
     */
    public function make()
    {
        if (!$this->isDone()) {
            $data = [
                'default' => serialize($this->default),
                'subject' => $this->subject->getClaim()
            ];

            $this->base64 = Base64URL::encode(self::jsonEncode($data));

            $this->done = true;
        }

        return $this->base64;
    }

    /**
     * @return bool
     */
    public function expired()
    {
        return ($this->default->expired + $this->default->updatedAt) <= time();
    }

    /**
     * @param bool $terminate
     * @param int $moreTtl
     * @return bool
     * @throws SingletonTokenException
     */
    public function refresh(bool $terminate = false, int $moreTtl = 0)
    {
        if ($this->default->singleton) {
            throw new SingletonTokenException;
        }

        $this->singleton($terminate);

        $this->ttl($this->default->expired + $moreTtl);

        $this->default->updatedAt = time() + mt_rand(1, 3);

        $this->done = false;

        return true;
    }

    /**
     * @param Header $header
     * @param string $payload
     * @return Payload
     * @throws BadPayloadException
     * @throws InvalidDefaultPayloadException
     */
    public static function generate(Header $header, string $payload)
    {
        $data = Base64URL::decode($payload);

        if (is_bool($data)) {
            throw new BadPayloadException;
        }

        $data = self::jsonDecode($data);

        list('default' => $default, 'subject' => $subject) = $data;

        return (new self($header->getAlgorithm()))->setDefault($default)->setSubject($subject);
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->make();
    }
}
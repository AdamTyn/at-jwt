<?php

namespace AdamTyn\AT\JWT;

use AdamTyn\AT\JWT\Exceptions\DifferentAlgorithmException;

/**
 * @author AdamTyn
 *
 * @method JWT ttl(int $seconds)
 * @method JWT singleton(bool $open)
 * @method JWT refresh(bool $terminate, int $moreTtl)
 */
class JWT
{
    /**
     * @var Header
     */
    protected $header;

    /**
     * @var PayLoad
     */
    protected $payload;

    /**
     * @var string
     */
    protected $token;

    /**
     * @var bool
     */
    protected $signed = false;

    /**
     * @var string
     */
    protected $signature = '';

    /**
     * JWT constructor.
     */
    public function __construct()
    {
        $this->header = new Header;

        $this->payload = new PayLoad($this->header->getAlgorithm());
    }

    /**
     * @param Header $header
     * @return JWT
     */
    public function withHeader(Header $header)
    {
        $this->header = $header;

        $this->signed = false;

        return $this;
    }

    /**
     * @param Payload $payload
     * @return JWT
     *
     * @throws DifferentAlgorithmException
     */
    public function withPayload(Payload $payload)
    {
        if ($payload->getAlgorithm() !== $this->getHeader()->getAlgorithm()) {
            throw new DifferentAlgorithmException;
        }

        $this->payload = $payload;

        $this->signed = false;

        return $this;
    }

    /**
     * @param array $claim
     * @return JWT
     */
    public function withClaim(array $claim)
    {
        $this->getPayload()->setSubject($claim);

        $this->signed = false;

        return $this;
    }

    /**
     * @return Header
     */
    public function getHeader()
    {
        return $this->header;
    }

    /**
     * @return PayLoad
     */
    public function getPayload()
    {
        return $this->payload;
    }

    /**
     * @return string
     */
    public function getToken()
    {
        if (!$this->signed) {
            $this->sign(strval($this->header), strval($this->payload));
        }

        return $this->token;
    }

    /**
     * @param string $header
     * @param string $payload
     * @return string
     */
    public function sign(string $header, string $payload)
    {
        $data = implode('.', [$header, $payload]);

        $this->signature = $this->header->getAlgorithm()->transport($data);

        $this->token = implode('.', [$header, $payload, $this->signature]);

        $this->signed = true;

        return $this->signature;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->getToken();
    }

    /**
     * @return JWT
     */
    public function __call($name, $arguments)
    {
        $this->getPayload()->$name(...$arguments);

        $this->signed = false;

        return $this;
    }
}
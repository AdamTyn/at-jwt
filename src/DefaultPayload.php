<?php

namespace AdamTyn\AT\JWT;

use AdamTyn\AT\JWT\Contracts\Arrayable;

class DefaultPayload implements Arrayable
{
    /**
     * @var int
     */
    public $expired = 10;

    /**
     * @var int
     */
    public $createdAt = 0;

    /**
     * @var int
     */
    public $updatedAt = 0;

    /**
     * @var bool
     */
    public $singleton = false;

    /**
     * @return array
     */
    public function __sleep()
    {
        if ($this->createdAt < 1) {
            $this->createdAt = time();
            $this->updatedAt = $this->createdAt;
        }

        return ['expired', 'createdAt', 'updatedAt', 'singleton'];
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return [
            'expired' => $this->expired,
            'createdAt' => $this->createdAt,
            'updatedAt' => $this->updatedAt,
            'singleton' => $this->singleton
        ];
    }
}
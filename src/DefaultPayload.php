<?php

namespace AdamTyn\AT\JWT;

class DefaultPayload
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
}
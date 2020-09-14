<?php

namespace AdamTyn\AT\JWT;

use AdamTyn\AT\JWT\Contracts\Arrayable;

class DefaultSubject implements Arrayable
{
    /**
     * @var array
     */
    protected $claim = [];

    /**
     * @param array $claim
     * @return DefaultSubject
     */
    public function setClaim(array $claim)
    {
        if (count($claim) > 0) {
            $this->claim = $claim + $this->claim;
        }

        return $this;
    }

    /**
     * @return array
     */
    public function getClaim()
    {
        if (count($this->claim) < 1) {
            return [
                'uuid' => 0,
                'tourist' => true
            ];
        }

        return $this->claim;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return $this->getClaim();
    }
}
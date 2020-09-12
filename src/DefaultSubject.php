<?php

namespace AdamTyn\AT\JWT;

use AdamTyn\AT\JWT\Contracts\SubjectInterface as Subject;

class DefaultSubject implements Subject
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
        $this->claim = $claim + $this->claim;

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
}
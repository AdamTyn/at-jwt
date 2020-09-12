<?php

namespace AdamTyn\AT\JWT\Contracts;

interface SubjectInterface
{
    /**
     * @return array
     */
    public function getClaim();

    /**
     * @param array $claim
     * @return mixed
     */
    public function setClaim(array $claim);
}
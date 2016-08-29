<?php

namespace DBonner\Identifier\Contracts;

interface IdentifierInterface
{
    /**
     * Return the identifier as a string
     *
     * @return string
     */
    public function toString();
}

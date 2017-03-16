<?php

namespace DBonner\Identifier\Contracts;

abstract class AbstractIdentifier implements IdentifierInterface
{
    /**
     * @var mixed
     */
    protected $value;

    /**
     * Creates an identifier object from a string.
     *
     * @param  $string
     *
     * @return Identifier
     */
    public static function fromString($string)
    {
        return new static($string);
    }

    /**
     * Return the identifier as a string.
     *
     * @return string
     */
    public function toString()
    {
        return (string) $this->value;
    }

    /**
     * Return the identifier as a string.
     *
     * @return string
     */
    public function __toString()
    {
        return $this->toString();
    }
}

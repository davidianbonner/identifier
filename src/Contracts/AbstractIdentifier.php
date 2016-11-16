<?php

namespace DBonner\Identifier\Contracts;

abstract class AbstractIdentifier implements IdentifierInterface
{
    /**
     * @var int
     */
    protected $value;

    /**
     * Creates an identifier object from a string.
     *
     * @param  $string
     *
     * @return Identifier
     */
    abstract public static function fromString($string);

    /**
     * Return the raw value.
     *
     * @return mixed
     */
    public function raw()
    {
        return $this->value;
    }

    /**
     * Determine equality with another Value Object.
     *
     * @param Identifier $other
     *
     * @return bool
     */
    public function equals(IdentifierInterface $other)
    {
        return $this == $other;
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

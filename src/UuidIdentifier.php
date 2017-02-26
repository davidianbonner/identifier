<?php

namespace DBonner\Identifier;

use Assert\Assertion;
use Ramsey\Uuid\Uuid;
use DBonner\Identifier\Contracts\AbstractIdentifier;
use DBonner\Identifier\Contracts\IdentifierInterface;

class UuidIdentifier extends AbstractIdentifier implements IdentifierInterface
{
    /**
     * @var int
     */
    protected $value;

    /**
     * Create a new UserId.
     *
     * @return void
     */
    public function __construct($value)
    {
        Assertion::string($value);
        Assertion::length(36);
        $this->value = $value;
    }

    /**
     * {@inheritdoc}
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
     * Generate a new UUID identifier object.
     *
     * @return DBonner\Identifier\UuidIdentifier
     */
    public static function generate()
    {
        return new static(Uuid::uuid4()->toString());
    }
}

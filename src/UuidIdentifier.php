<?php

namespace DBonner\Identifier;

use Assert\Assertion;
use Ramsey\Uuid\Uuid;
use DBonner\Identifier\Contracts\AbstractIdentifier;
use DBonner\Identifier\Contracts\IdentifierInterface;

class UuidIdentifier extends AbstractIdentifier implements IdentifierInterface
{
    /**
     * Create a new UserId.
     *
     * @return void
     */
    public function __construct($value)
    {
        Assertion::string($value);
        Assertion::length($value, 36);
        $this->value = $value;
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

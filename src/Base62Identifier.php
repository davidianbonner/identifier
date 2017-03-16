<?php

namespace DBonner\Identifier;

use Assert\Assertion;
use DBonner\Identifier\Contracts\AbstractIdentifier;
use DBonner\Identifier\Contracts\IdentifierInterface;
use DBonner\Identifier\Types\Base62;

class Base62Identifier extends AbstractIdentifier implements IdentifierInterface
{
    /**
     * Create a new UserId.
     *
     * @return void
     */
    public function __construct($value)
    {
        Assertion::integer($value);
        $this->value = $value;
    }

    /**
     * {@inheritdoc}
     */
    public static function decode($string)
    {
        return new static(Base62::fromBase62($string));
    }

    /**
     * Return the identifier as a string.
     *
     * @return string
     */
    public function encode()
    {
        return Base62::toBase62($this->value);
    }
}

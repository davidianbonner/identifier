<?php

namespace DBonner\Identifier;

use Assert\Assertion;
use DBonner\Identifier\Types\Base62;
use DBonner\Identifier\Contracts\AbstractIdentifier;
use DBonner\Identifier\Contracts\IdentifierInterface;

class Base62Identifier extends AbstractIdentifier implements IdentifierInterface
{
    /**
     * @var integer
     */
    protected $value;

    /**
     * Create a new UserId
     *
     * @return void
     */
    public function __construct($value)
    {
        Assertion::integer($value);
        $this->value = $value;
    }

    /**
     * @inheritdoc
     */
    public static function fromString($string)
    {
        return new static(
            Base62::fromBase62($string)
        );
    }

    /**
     * Return the identifier as a string
     *
     * @return string
     */
    public function toString()
    {
        return (string) Base62::toBase62($this->value);
    }
}

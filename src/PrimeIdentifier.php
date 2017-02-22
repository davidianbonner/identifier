<?php

namespace DBonner\Identifier;

use Assert\Assertion;
use Jenssegers\Optimus\Optimus;
use DBonner\Identifier\Contracts\AbstractIdentifier;
use DBonner\Identifier\Contracts\IdentifierInterface;

class PrimeIdentifier extends AbstractIdentifier implements IdentifierInterface
{
    /**
     * @var int
     */
    protected $value;

    /**
     * @var Jenssegers\Optimus\Optimus
     */
    protected $prime;

    /**
     * Create a new UserId.
     *
     * @return void
     */
    public function __construct($value)
    {
        $this->prime = $this->primeInstance();

        Assertion::integer($value);
        $this->value = $value;
    }

    /**
     * {@inheritdoc}
     */
    public static function fromString($string)
    {
        return new static(self::primeInstance()->decode($string));
    }

    /**
     * Return the identifier as a string.
     *
     * @return string
     */
    public function toString()
    {
        // Optimus returns an integer and __toString()
        // requires a string be returned.

        return (string) $this->prime->encode($this->value);
    }

    /**
     * Return a prime instance
     *
     * @return Jenssegers\Optimus\Optimus
     */
    protected static function primeInstance()
    {
        return new Optimus(
            config('identifier.prime_identifier'),
            config('identifier.prime_inverted'),
            config('identifier.prime_random')
        );
    }
}

<?php

namespace DBonner\Identifier;

use Assert\Assertion;
use Jenssegers\Optimus\Optimus;
use DBonner\Identifier\Contracts\AbstractIdentifier;
use DBonner\Identifier\Contracts\IdentifierInterface;

class PrimeId extends AbstractIdentifier implements IdentifierInterface
{
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
        Assertion::integer($value);
        $this->value = $value;
    }

    /**
     * {@inheritdoc}
     */
    public static function decode($string)
    {
        return new static(self::primeInstance()->decode($string));
    }

    /**
     * Return the identifier as a string.
     *
     * @return string
     */
    public function encode()
    {
        return $this->primeInstance()->encode($this->value);
    }

    /**
     * Return a prime instance
     *
     * @return Jenssegers\Optimus\Optimus
     */
    protected static function primeInstance()
    {
        return app(Optimus::class);
    }
}

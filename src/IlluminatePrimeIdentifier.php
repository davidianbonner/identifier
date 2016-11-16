<?php

namespace DBonner\Identifier;

use Jenssegers\Optimus\Optimus;
use DBonner\Identifier\PrimeIdentifier;

class IlluminatePrimeIdentifier extends PrimeIdentifier
{
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

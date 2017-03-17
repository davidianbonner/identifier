<?php

namespace DBonner\Identifier\Traits;

use DBonner\Identifier\PrimeId;
use Illuminate\Support\Facades\Config;

trait HasObfuscatedIds
{
    /**
     * Cast an attribute to a native PHP type.
     *
     * @param  string  $key
     * @param  mixed  $value
     * @return mixed
     */
    // protected function castAttribute($key, $value)
    // {
    //     if ($key == $this->getKeyName() && property_exists($this, 'primaryKeyCast')) {
    //         $key = $this->primaryKeyCast;
    //     }

    //     if ($class = Config::get('identifier.cast.'.$key, null)) {
    //         return $class::fromString($value);
    //     }

    //     return parent::castAttribute($key, $value);
    // }

    /**
     * Get the value of the model's primary key.
     *
     * @return mixed
     */
    public function getRouteKey()
    {
        return $this->getObfuscatedKey();
    }

    /**
     * Get the value of the model's obfuscated primary key.
     *
     * @return mixed
     */
    public function getObfuscatedKey($key = null)
    {
        return PrimeId::fromString($key ? $this->getAttribute($key) : $this->getKey())->encode();
    }
}

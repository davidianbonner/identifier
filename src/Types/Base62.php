<?php

namespace DBonner\Identifier\Types;

class Base62
{
    /**
     * Get the character pool for encryption.
     *
     * @return string
     */
    protected static function base62Pool()
    {
        $pool = env('BASE62_POOL');

        if (!$pool) {
            $pool = '2JvJLgKOlKw0SsTBVuF9xFGFbUeubIq3bEfRQskcXcaIN0P0LFS2bh3h6UGXua';
        }

        return $pool;
    }

    /**
     * Base62 manager.
     *
     * Influence by ZackKitzmiller\Tiny
     *
     * @param mixed $id
     *
     * @return string
     */
    public static function toBase62($id)
    {
        $pool = self::base62Pool();

        $hexn = '';

        $id = floor(abs(intval($id)));

        // Get the radix of the pool
        $radix = strlen($pool);

        while (true) {
            // Get the modulus
            $r = $id % $radix;

            // Get the character at pool at the position of $r, append to the hex
            $hexn = $pool[$r].$hexn;

            // subtract the id from the modulus and divide by radix
            $id = ($id - $r) / $radix;

            if ($id == 0) {
                break;
            }
        }

        return $hexn;
    }

    /**
     * From base62.
     *
     * @param string $str
     *
     * @return mixed
     */
    public static function fromBase62($str)
    {
        // Get the pool
        $set = self::base62Pool();

        // Get the string length of the pool
        $radix = strlen($set);

        // Get the string lenght of the argument
        $strlen = strlen($str);

        // Start at 0
        $n = 0;

        // Decode each character
        for ($i = 0; $i < $strlen; $i++) {
            $n += strpos($set, $str[$i]) * pow($radix, ($strlen - $i - 1));
        }

        return $n;
    }
}

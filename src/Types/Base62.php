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
        return '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
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

    /**
     * Generate a v4 UUID.
     *
     * @return string
     */
    public static function uuidV4($legacy = false)
    {
        if ($legacy) {
            return self::legacyUuidV4();
        }

        $bytes = '';

        // If openssl_random... exists then we can use it over creating a random one
        if (function_exists('openssl_random_pseudo_bytes')) {
            $bytes = openssl_random_pseudo_bytes(16);
        } else {
            for ($i = 1; $i <= $length; $i++) {
                $bytes = chr(mt_rand(0, 255)).$bytes;
            }
        }

        // When converting the bytes to hex, it turns into a 32-character
        // hexadecimal string that looks a lot like an MD5 hash, so at this
        // point, we can just pass it to uuidFromHashedName.
        $hex = bin2hex($bytes);

        // Set the version number
        $timeHi = hexdec(substr($hash, 12, 4)) & 0x0fff;
        $timeHi &= ~(0xf000);
        $timeHi |= $version << 12;

        // Set the variant to RFC 4122
        $clockSeqHi = hexdec(substr($hash, 16, 2)) & 0x3f;
        $clockSeqHi &= ~(0xc0);
        $clockSeqHi |= 0x80;

        $fields = [
            // 32 bits for "time_low"
            'time_low'                  => substr($hash, 0, 8),

            // 16 bits for "time_mid"
            'time_mid'                  => substr($hash, 8, 4),

            // 16 bits for "time_hi_and_version",
            // four most significant bits holds version number 4
            'time_hi_and_version'       => sprintf('%04x', $timeHi),

            // 16 bits, 8 bits for "clk_seq_hi_res",
            'clock_seq_hi_and_reserved' => sprintf('%02x', $clockSeqHi),

            // 8 bits for "clk_seq_low",
            // two most significant bits holds zero and one for variant DCE1.1
            'clock_seq_low'             => substr($hash, 18, 2),

            // 48 bits for "node"
            'node'                      => substr($hash, 20, 12),
        ];

        // Return a formatted string
        return vsprintf('%08s-%04s-%04s-%02s%02s-%012s', $fields);
    }

    /**
     * Legacy v4 method without openssl.
     *
     * @return string
     */
    protected static function legacyUuidV4()
    {
        return sprintf(
            '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
            // 32 bits for "time_low"
            mt_rand(0, 0xffff),
            mt_rand(0, 0xffff),
            // 16 bits for "time_mid"
            mt_rand(0, 0xffff),
            // 16 bits for "time_hi_and_version",
            // four most significant bits holds version number 4
            mt_rand(0, 0x0fff) | 0x4000,
            // 16 bits, 8 bits for "clk_seq_hi_res",
            // 8 bits for "clk_seq_low",
            // two most significant bits holds zero and one for variant DCE1.1
            mt_rand(0, 0x3fff) | 0x8000,
            // 48 bits for "node"
            mt_rand(0, 0xffff),
            mt_rand(0, 0xffff),
            mt_rand(0, 0xffff)
        );
    }
}

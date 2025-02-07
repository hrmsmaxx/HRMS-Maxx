<?php

namespace PragmaRX\Google2FA\Support;

use ParagonIE\ConstantTime\Base32 as ParagonieBase32;
use PragmaRX\Google2FA\Exceptions\SecretKeyTooShortException;
use PragmaRX\Google2FA\Exceptions\InvalidCharactersException;
use PragmaRX\Google2FA\Exceptions\IncompatibleWithGoogleAuthenticatorException;

trait Base32
{
    /**
     * Enforce Google Authenticator compatibility.
     */
    protected $enforceGoogleAuthenticatorCompatibility = true;

    /**
     * Calculate char count bits.
     *
     * @param $b32
     * @return float|int
     */
    protected function charCountBits($b32)
    {
        return (strlen($b32) * 8);
    }

    /**
     * Generate a digit secret key in base32 format.
     *
     * @param int    $length
     * @param string $prefix
     *
     * @throws IncompatibleWithGoogleAuthenticatorException
     * @throws InvalidCharactersException
     *
     * @return string
     */
    public function generateBase32RandomKey($length = 16, $prefix = '')
    {
        $secret = $prefix ? $this->toBase32($prefix) : '';

        $secret = $this->strPadBase32($secret, $length);

        $this->validateSecret($secret);

        return $secret;
    }

    /**
     * Decodes a base32 string into a binary string.
     *
     * @param string $b32
     *
     * @throws InvalidCharactersException
     * @throws IncompatibleWithGoogleAuthenticatorException
     *
     * @return int
     */
    public function base32Decode($b32)
    {
        $b32 = strtoupper($b32);

        $this->validateSecret($b32);

        return ParagonieBase32::decodeUpper($b32);
    }

    /**
     * Check if the string length is power of two.
     *
     * @param $b32
     * @return bool
     */
    protected function isCharCountNotAPowerOfTwo($b32): bool
    {
        return (strlen($b32) & (strlen($b32) - 1)) !== 0;
    }

    /**
     * Pad string with random base 32 chars.
     *
     * @param $string
     * @param $length
     *
     * @throws \Exception
     *
     * @return string
     */
    private function strPadBase32($string, $length)
    {
        for ($i = 0; $i < $length; $i++) {
            $string .= substr(
                Constants::VALID_FOR_B32_SCRAMBLED,
                $this->getRandomNumber(),
                1
            );
        }

        return $string;
    }

    /**
     * Encode a string to Base32.
     *
     * @param $string
     *
     * @return mixed
     */
    public function toBase32($string)
    {
        $encoded = ParagonieBase32::encodeUpper($string);

        return str_replace('=', '', $encoded);
    }

    /**
     * Get a random number.
     *
     * @param $from
     * @param $to
     *
     * @throws \Exception
     *
     * @return int
     */
    protected function getRandomNumber($from = 0, $to = 31)
    {
        return random_int($from, $to);
    }

    /**
     * Validate the secret.
     *
     * @param $b32
     *
     * @throws IncompatibleWithGoogleAuthenticatorException
     * @throws InvalidCharactersException
     */
    protected function validateSecret($b32)
    {
        $this->checkForValidCharacters($b32);

        $this->checkGoogleAuthenticatorCompatibility($b32);

        $this->checkIsBigEnough($b32);
    }

    /**
     * Check if the secret key is compatible with Google Authenticator.
     *
     * @param $b32
     *
     * @throws IncompatibleWithGoogleAuthenticatorException
     */
    protected function checkGoogleAuthenticatorCompatibility($b32)
    {
        if (
            $this->enforceGoogleAuthenticatorCompatibility &&
            $this->isCharCountNotAPowerOfTwo($b32) // Google Authenticator requires it to be a power of 2 base32 length string
        ) {
            throw new IncompatibleWithGoogleAuthenticatorException();
        }
    }

    /**
     * Check if all secret key characters are valid.
     *
     * @param $b32
     *
     * @throws InvalidCharactersException
     */
    protected function checkForValidCharacters($b32)
    {
        if (
            preg_replace('/[^' . Constants::VALID_FOR_B32 . ']/', '', $b32) !==
            $b32
        ) {
            throw new InvalidCharactersException();
        }
    }

    /**
     * Check if secret key length is big enough
     *
     * @param $b32
     *
     * @throws InvalidCharactersException
     */
    protected function checkIsBigEnough($b32)
    {
        // Minimum = 128 bits
        // Recommended = 160 bits
        // Compatible with Google Authenticator = 256 bits

        if (
            $this->charCountBits($b32) < 128
        ) {
            throw new SecretKeyTooShortException();
        }
    }
}

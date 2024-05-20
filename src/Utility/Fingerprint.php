<?php

namespace Soldo\Utility;

use Soldo\Error\InvalidFingerprintException;
use Soldo\Webservice\Driver\Soldo;

class Fingerprint
{
    /**
     * Generates a fingerprint based on the given parameters
     * 
     * @param string[] $fingerprint_order The fingerprint order to use.
     * @param array $parameters The parameters from which to take the values if
     * the fingerprint order requires them.
     * @param string $token The token.
     * 
     * @return string
     * 
     * @link https://developer.soldo.com/docs/advanced-authentication
     */
    public static function generate(array $fingerprint_order, array $parameters, string $token)
    {
        $data = $token;

        if (!empty($fingerprint_order) && !empty($parameters)) {
            foreach (array_reverse(array_values($fingerprint_order)) as $parameter) {
                if (isset($parameters[$parameter]) && !empty($parameters[$parameter])) {
                    $data = (is_array($parameters[$parameter]) ? implode('', $parameters[$parameter]) : $parameters[$parameter]) . $data;
                }
            }
        }

        return hash('sha512', $data);
    }

    /**
     * Signs the given fingerprint with the given private key
     * 
     * @param string $fingerprint The fingerprint to sign.
     * @param string $private_key The RSA private key shared with Soldo, encoded
     * in Base64.
     * 
     * @return string
     * 
     * @link https://developer.soldo.com/docs/advanced-authentication
     */
    public static function sign(string $fingerprint, string $private_key)
    {
        $private_key_resource = openssl_pkey_get_private($private_key);

        if (!$private_key_resource) {
            throw new InvalidFingerprintException('Could not retrieve the private key needed for signing the fingerprint');
        }

        $fingerprint_signature = '';
        if (openssl_sign($fingerprint, $fingerprint_signature, $private_key_resource, OPENSSL_ALGO_SHA512)) {
            $base64_fingerprint_signature = base64_encode($fingerprint_signature);
            openssl_free_key($private_key_resource);

            return $base64_fingerprint_signature;
        } else {
            throw new InvalidFingerprintException('Could not generate the signature for the private key needed for signing the fingerprint');
        }
    }

    /**
     * Decrypts the ciphertext using the private key stored in the cache or the
     * one given as a parameter
     * 
     * @param string $ciphertext The ciphertext to decrypt.
     * @param string $private_key The RSA private key to use to decrypt the
     * ciphertext, encoded in Base64.
     * 
     * @return string
     * 
     * @link https://developer.soldo.com/docs/advanced-authentication
     */
    public static function decrypt(string $ciphertext, string $private_key = null)
    {
        try {
            // In case the given ciphertext is encoded in Base64, it decodes it
            $decoded_ciphertext = base64_decode($ciphertext, true);
            if ($decoded_ciphertext !== false) {
                $encoded_ciphertext = base64_encode($decoded_ciphertext);

                if ($ciphertext === $encoded_ciphertext) {
                    $ciphertext = $decoded_ciphertext;
                }
            }

            if (!$private_key) {
                $private_key = \Cake\Cache\Cache::read(Soldo::PRIVATE_KEY_CACHE_KEY);
            }

            if (!is_string($private_key)) {
                throw new InvalidFingerprintException('Could not retrieve the private key needed for decrypting the ciphertext');
            }

            $private_key = base64_decode($private_key);

            if (!is_string($private_key)) {
                throw new InvalidFingerprintException('Could not decode the private key from Base64 needed for decrypting the ciphertext');
            }

            /** @var \phpseclib3\Crypt\RSA\PrivateKey $rsa */
            $rsa = \phpseclib3\Crypt\PublicKeyLoader::load($private_key);

            $rsa->withPadding(\phpseclib3\Crypt\RSA::ENCRYPTION_OAEP);
            $rsa->withMGFHash('sha256');
            $rsa->withHash('sha256');

            $decrypted_ciphertext = $rsa->decrypt($ciphertext);

            if (!is_string($decrypted_ciphertext)) {
                throw new InvalidFingerprintException('Could not decrypt the ciphertext');
            }
        } catch (\Exception $e) {
            throw new InvalidFingerprintException('Error while decrypting the ciphertext');
        }

        return $decrypted_ciphertext;
    }
}

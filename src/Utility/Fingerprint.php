<?php

namespace Soldo\Utility;

use Soldo\Error\InvalidFingerprintException;

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
                    $data = $parameters[$parameter] . $data;
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
            throw new InvalidFingerprintException('Could not retrieve the private key needed for the advanced authentication');
        }

        $fingerprint_signature = '';
        if (openssl_sign($fingerprint, $fingerprint_signature, $private_key_resource, OPENSSL_ALGO_SHA512)) {
            $base64_fingerprint_signature = base64_encode($fingerprint_signature);
            openssl_free_key($private_key_resource);

            return $base64_fingerprint_signature;
        } else {
            throw new InvalidFingerprintException('Could not generate the signature for the private key needed for the advanced authentication');
        }
    }
}

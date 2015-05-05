<?php

namespace DevFriendlyPhpJwt;

use DevFriendlyPhpJwt\Enum\Algorithm;
use \JWT as FirebasePhpJwt;

/**
 * @author Alexandre Rodrigues Xavier <contato@alexandrexavier.com.br>
 *
 * @package DevFriendlyPhpJwt
 */
class Validator
{
    /**
     * @param string   $token
     * @param string   $key
     * @param ClaimSet $match
     * @param string   $algorithm [optional] HS512
     *
     * @throws \DomainException           Algorithm was not provided
     * @throws \UnexpectedValueException  Provided JWT was invalid
     * @throws \SignatureInvalidException Provided JWT was invalid because the signature verification failed
     * @throws \BeforeValidException      Provided JWT is trying to be used before it's eligible as defined by 'nbf'
     * @throws \BeforeValidException      Provided JWT is trying to be used before it's been created as defined by 'iat'
     * @throws \ExpiredException          Provided JWT has since expired, as defined by the 'exp' claim
     * @throws Exception                  Provided JWT was invalid
     */
    public function validate($token, $key, ClaimSet $match, $algorithm = Algorithm::HS512)
    {
        $decoded = FirebasePhpJwt::decode(
            $token,
            $key,
            [$algorithm]
        );

        foreach ($match->toArray() as $claim => $expectedValue) {
            if (isset($decoded->$claim) && $decoded->$claim == $expectedValue) {
                continue;
            }

            throw new Exception("Provided JWT was invalid because the '{$claim}' verification failed");
        }
    }
}

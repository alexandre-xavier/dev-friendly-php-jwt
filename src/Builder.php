<?php

namespace DevFriendlyPhpJwt;

/**
 * @author Alexandre Rodrigues Xavier <contato@alexandrexavier.com.br>
 *
 * @package DevFriendlyPhpJwt
 */
class Builder
{
    /**
     * @param string  $subject
     * @param string  $issuer   [optional] default null
     * @param string  $audience [optional] default null
     * @param string  $jwtId    [optional] default null
     * @param string  $type     [optional] default null
     *
     * @return ClaimSet
     */
    public static function newMatchingToken(
        $subject,
        $issuer = null,
        $audience = null,
        $jwtId = null,
        $type = null
    ) {
        $claim = new ClaimSet();

        return $claim->setSubject($subject)
            ->setIssuer($issuer)
            ->setAudience($audience)
            ->setType($type)
            ->setJwtId($jwtId)
        ;
    }

    /**
     * @param string  $subject
     * @param string  $issuer              [optional] default null
     * @param string  $audience            [optional] default null
     * @param string  $jwtId               [optional] default null
     * @param string  $type                [optional] default null
     * @param integer $expirationInSeconds [optional] default 30
     *
     * @return ClaimSet
     */
    public static function newRequestToken(
        $subject,
        $issuer = null,
        $audience = null,
        $jwtId = null,
        $type = null,
        $expirationInSeconds = 30
    ) {
        $claim = static::newClaimSetExpiringIn($expirationInSeconds)
            ->setIssuer($issuer)
            ->setAudience($audience)
            ->setSubject($subject)
            ->setType($type)
            ->setJwtId($jwtId)
        ;

        return $claim;
    }

    /**
     * @static
     *
     * @param integer $expirationInSeconds [optional] default 30
     *
     * @return ClaimSet
     */
    public static function newClaimSetExpiringIn($expirationInSeconds = 30)
    {
        $issuedAt = time();
        $expirationTime = strtotime("+{$expirationInSeconds} seconds", $issuedAt);
        $claim = new ClaimSet();

        return
            $claim->setIssuedAt($issuedAt)
                ->setNotBefore($issuedAt)
                ->setExpirationTime($expirationTime)
            ;
    }
}

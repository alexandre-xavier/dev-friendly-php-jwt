<?php

namespace DevFriendlyPhpJwt;

/**
 * @author Alexandre Rodrigues Xavier <contato@alexandrexavier.com.br>
 *
 * @package DevFriendlyPhpJwt
 */
class ClaimSet
{
    /**
     * @var array
     */
    protected $metadata = [
        'issuer' => 'iss',
        'subject' => 'sub',
        'audience' => 'aud',
        'expirationTime' => 'exp',
        'notBefore' => 'nbf',
        'issuedAt' => 'iat',
        'jwtId' => 'jti',
        'type' => 'typ',
    ];

    /**
     * 4.1.1. "iss" (Issuer) Claim
     *
     * The "iss" (issuer) claim identifies the principal that issued the JWT.
     * The processing of this claim is generally application specific.
     * The "iss" value is a case sensitive string containing a StringOrURI value.
     * Use of this claim is @optional.
     *
     * @var string
     */
    protected $issuer;

    /**
     * 4.1.2. "sub" (Subject) Claim
     *
     * The "sub" (subject) claim identifies the principal that is the subject of the JWT.
     * The Claims in a JWT are normally statements about the subject.
     * The processing of this claim is generally application specific.
     * The "sub" value is a case sensitive string containing a StringOrURI value.
     * Use of this claim is @optional.
     *
     * @var string
     */
    protected $subject;

    /**
     * 4.1.3. "aud" (Audience) Claim
     *
     * The "aud" (audience) claim identifies the audiences that the JWT is intended for.
     * Each principal intended to process the JWT MUST identify itself with a value in audience claim.
     * If the principal processing the claim does not identify itself with a value in the "aud" claim,
     * then the JWT MUST be rejected.
     * In the general case, the "aud" value is an array of case sensitive strings, each containing a StringOrURI value.
     * In the special case when the JWT has one audience, the "aud" value MAY be a single case sensitive string
     * containing a StringOrURI value.
     * The interpretation of audience values is generally application specific.
     * Use of this claim is @optional.
     *
     * @var string
     */
    protected $audience;

    /**
     * 4.1.4. "exp" (Expiration Time) Claim
     *
     * The "exp" (expiration time) claim identifies the expiration time on or after which the JWT MUST NOT be accepted
     * for processing.
     * The processing of the "exp" claim requires that the current date/time MUST be before the expiration date/time
     * listed in the "exp" claim.
     * Implementers MAY provide for some small leeway, usually no more than a few minutes, to account for clock skew.
     * Its value MUST be a number containing an IntDate value.
     * Use of this claim is @optional.
     *
     * @var integer
     */
    protected $expirationTime;

    /**
     * 4.1.5. "nbf" (Not Before) Claim
     *
     * The "nbf" (not before) claim identifies the time before which the JWT MUST NOT be accepted for processing.
     * The processing of the "nbf" claim requires that the current date/time MUST be after or equal to
     * the not-before date/time listed in the "nbf" claim.
     * Implementers MAY provide for some small leeway, usually no more than a few minutes, to account for clock skew.
     * Its value MUST be a number containing an IntDate value.
     * Use of this claim is @optional.
     *
     * @var integer
     */
    protected $notBefore;

    /**
     * 4.1.6. "iat" (Issued At) Claim
     *
     * The "iat" (issued at) claim identifies the time at which the JWT was issued.
     * This claim can be used to determine the age of the JWT.
     * Its value MUST be a number containing an IntDate value.
     * Use of this claim is @optional.
     *
     * @var integer
     */
    protected $issuedAt;

    /**
     * 4.1.7. "jti" (JWT ID) Claim
     *
     * The "jti" (JWT ID) claim provides a unique identifier for the JWT.
     * The identifier value MUST be assigned in a manner that ensures that there is a negligible probability
     * that the same value will be accidentally assigned to a different data object.
     * The "jti" claim can be used to prevent the JWT from being replayed.
     * The "jti" value is a case sensitive string.
     * Use of this claim is @optional.
     *
     * @var string
     */
    protected $jwtId;

    /**
     * 4.1.8. "typ" (Type) Claim
     *
     * The "typ" (type) claim is used to declare a type for the contents of this JWT Claims Set.
     * The "typ" value is a case sensitive string.
     * Use of this claim is @optional.
     *
     * The values used for the "typ" claim come from the same value space as the "typ" header parameter,
     * with the same rules applying.
     *
     * @var string
     */
    protected $type;

    /**
     * @return array
     */
    public function toArray()
    {
        $asArray = [];

        foreach (get_object_vars($this) as $propertyName => $value) {
            if (isset($this->metadata[$propertyName]) && null != $value) {
                $jwtKey = $this->metadata[$propertyName];
                $asArray[$jwtKey] = $value;
            }
        }

        return $asArray;
    }

    /**
     * @param object $decoded
     *
     * @return $this
     */
    public function setDataFromDecoded($decoded)
    {
        $index = array_flip($this->metadata);

        foreach (get_object_vars($decoded) as $jwtKey => $value) {
            if (!isset($index[$jwtKey])) {
                continue;
            }

            $propertyName = $index[$jwtKey];

            if (property_exists($this, $propertyName)) {
                $this->$propertyName = $value;
            }
        }

        return $this;
    }

    /**
     * @param string $key
     * @param string $algorithm
     *
     * @return string
     */
    public function encode($key, $algorithm)
    {
        return JWT::encode($this->toArray(), $key, $algorithm);
    }

    /**
     * @return string
     */
    public function getIssuer()
    {
        return $this->issuer;
    }

    /**
     * @return string
     */
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * @return string
     */
    public function getAudience()
    {
        return $this->audience;
    }

    /**
     * @return integer
     */
    public function getExpirationTime()
    {
        return $this->expirationTime;
    }

    /**
     * @return integer
     */
    public function getNotBefore()
    {
        return $this->notBefore;
    }

    /**
     * @return integer
     */
    public function getIssuedAt()
    {
        return $this->issuedAt;
    }

    /**
     * @return string
     */
    public function getJwtId()
    {
        return $this->jwtId;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param string $issuer
     *
     * @return $this
     */
    public function setIssuer($issuer)
    {
        $this->issuer = $issuer;

        return $this;
    }

    /**
     * @param string $subject
     *
     * @return $this
     */
    public function setSubject($subject)
    {
        $this->subject = $subject;

        return $this;
    }

    /**
     * @param string $audience
     *
     * @return $this
     */
    public function setAudience($audience)
    {
        $this->audience = $audience;

        return $this;
    }

    /**
     * @param integer $expirationTime
     *
     * @return $this
     */
    public function setExpirationTime($expirationTime)
    {
        $this->expirationTime = $expirationTime;

        return $this;
    }

    /**
     * @param integer $notBefore
     *
     * @return $this
     */
    public function setNotBefore($notBefore)
    {
        $this->notBefore = $notBefore;

        return $this;
    }

    /**
     * @param integer $issuedAt
     *
     * @return $this
     */
    public function setIssuedAt($issuedAt)
    {
        $this->issuedAt = $issuedAt;

        return $this;
    }

    /**
     * @param string $jwtId
     *
     * @return $this
     */
    public function setJwtId($jwtId)
    {
        $this->jwtId = $jwtId;

        return $this;
    }

    /**
     * @param string $type
     *
     * @return $this
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }
}

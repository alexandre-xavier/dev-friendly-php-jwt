<?php

namespace DevFriendlyPhpJwt;

/**
 * @author Alexandre Rodrigues Xavier <contato@alexandrexavier.com.br>
 *
 * @package DevFriendlyPhpJwt
 */
class Exception extends \Exception
{
    /**
     * @var string
     */
    protected $message = 'Provided JWT was invalid';

    /**
     * @var integer
     */
    protected $code = 401;
}

<?php

namespace DevFriendlyPhpJwt;

use PHPUnit_Framework_TestCase as PHPUnit;

/**
 * @author Alexandre Rodrigues Xavier <alexandre.rodrigues.xv@gmail.com>
 *
 * @package DevFriendlyPhpJwt\Tests
 */
class FirstTest extends PHPUnit
{
    public function testInstanceCreation()
    {
        $this->assertInstanceOf(
            'DevFriendlyPhpJwt\First',
            new \stdClass(),//new First(),
            'Assert instance of: DevFriendlyPhpJwt\First'
        );
    }
}

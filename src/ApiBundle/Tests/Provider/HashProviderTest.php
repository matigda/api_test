<?php

namespace ApiBundle\Test\Provider;

use ApiBundle\Provider\HashProvider;

class HashProviderTest extends \PHPUnit_Framework_TestCase
{
    public function testGetHash()
    {
        // given
        $provider = new HashProvider();

        // when
        $hash = $provider->getHash('some string');

        // then
        $this->assertSame(md5('some string'), $hash);
    }
}

<?php

namespace ApiBundle\Test\Provider;

use ApiBundle\DataFixtures\MongoDB\LoadPubData;
use ApiBundle\Exception\PubNotFoundException;
use ApiBundle\Provider\PubProvider;
use ApiBundle\Tests\AbstractFunctionalTest;
use Symfony\Component\HttpFoundation\Request;

class PubProviderTest extends AbstractFunctionalTest
{
    /**
     * @var PubProvider
     */
    private $pubProvider;

    public function setUp()
    {
        parent::setUp();

        $this->loadFixtures([LoadPubData::class], null, 'doctrine_mongodb');

        $this->pubProvider = $this->container->get('api.pub.provider');
    }

    public function testGetPubs()
    {
        $request = new Request();
        $pubs = $this->pubProvider->getPubs($request);

        $this->assertTrue(count($pubs) == 3);

        $this->assertTrue(reset($pubs)->getName() == 'Absynt');

        $this->assertTrue(next($pubs)->getName() == 'Zimne nóżki');

        $this->assertTrue(next($pubs)->getName() == 'Parlament');
    }

    public function testGetPubsWithGivenCoordinates()
    {
        $request = new Request();
        $request->query->set('lat', 38.8993487);
        $request->query->set('long', -77.0145665);
        $request->query->set('radius', 2);

        $pubs = $this->pubProvider->getPubs($request);

        $this->assertTrue(count($pubs) == 2);

        $this->assertTrue(reset($pubs)->getName() == 'Washington DC');

        $this->assertTrue(next($pubs)->getName() == 'Library of Congress');
    }

    public function testGetPub()
    {
        $request = new Request();

        $pubs = $this->pubProvider->getPubs($request);

        $pub = reset($pubs);

        $result = $this->pubProvider->getPub($pub->getId());

        $this->assertSame($result, $pub);
    }

    public function testGetPubThrowExceptionWhenPubNotFound()
    {
        $this->setExpectedException(PubNotFoundException::class);

        $this->pubProvider->getPub('xx');
    }
}

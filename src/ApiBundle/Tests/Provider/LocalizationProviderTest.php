<?php

namespace ApiBundle\Test\Provider;

use ApiBundle\Provider\LocalizationProvider;
use Symfony\Component\HttpFoundation\Request;

class LocalizationProviderTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var LocalizationProvider
     */
    private $provider;

    public function setUp()
    {
        $this->provider = new LocalizationProvider(5, 6, 2);
    }

    public function testGetLocalizationData()
    {
        $request = new Request();
        list($lat, $long, $radius) = $this->provider->getLocalizationData($request);

        $this->assertTrue($lat == 5);

        $this->assertTrue($long == 6);

        $this->assertTrue($radius == 2);
    }

    public function testGetLocalizationDataWithNotEmptyRequest()
    {
        $request = new Request();
        $request->query->set('lat', 7);
        $request->query->set('long', 8);
        $request->query->set('radius', 10);

        list($lat, $long, $radius) = $this->provider->getLocalizationData($request);

        $this->assertTrue($lat == 7);

        $this->assertTrue($long == 8);

        $this->assertTrue($radius == 10);
    }
}

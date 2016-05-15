<?php

namespace ApiBundle\Provider;

use Symfony\Component\HttpFoundation\Request;

class LocalizationProvider
{
    /**
     * @var float
     */
    private $pointLatitude;

    /**
     * @var float
     */
    private $pointLongitude;

    /**
     * @var int
     */
    private $radius;

    /**
     * @param float $pointLatitude
     * @param float $pointLongitude
     * @param int   $radius
     */
    public function __construct($pointLatitude, $pointLongitude, $radius)
    {
        $this->pointLatitude = (float) $pointLatitude;
        $this->pointLongitude = (float) $pointLongitude;
        $this->radius = (int) $radius;
    }

    public function getLocalizationData(Request $request)
    {
        $lat = $request->get('lat') ? (float) $request->get('lat') : $this->pointLatitude;
        $long = $request->get('long') ? (float) $request->get('long') : $this->pointLongitude;
        $radius = $request->get('radius') ? (int) $request->get('radius') : $this->radius;

        return [$lat, $long, $radius];
    }
}

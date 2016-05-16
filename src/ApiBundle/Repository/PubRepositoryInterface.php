<?php

namespace ApiBundle\Repository;

use Doctrine\ODM\MongoDB\MongoDBException;

interface PubRepositoryInterface
{

    /**
     * @param float $lat
     * @param float $long
     * @param int   $radius
     *
     * @return array
     *
     * @throws MongoDBException
     */
    public function getPubsNearCoordinatesWithinRadius($lat, $long, $radius);
}

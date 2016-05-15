<?php

namespace ApiBundle\Repository;

use Doctrine\ODM\MongoDB\Cursor;
use Doctrine\ODM\MongoDB\DocumentRepository;
use Doctrine\ODM\MongoDB\MongoDBException;

class PubRepository extends DocumentRepository
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
    public function getPubsNearCoordinatesWithinRadius($lat, $long, $radius)
    {
        /** @var Cursor $result */
        $result = $this->createQueryBuilder()
                ->field('localization')
                ->geoWithinCenterSphere($long, $lat, $this->transformRadiansToKilometers($radius))
                ->getQuery()
                ->execute();

        return $result->toArray();
    }

    /**
     * @param int $radius
     *
     * @return float
     */
    private function transformRadiansToKilometers($radius)
    {
        return (float) $radius / 6371;
    }
}

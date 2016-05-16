<?php

namespace ApiBundle\Repository;

use Doctrine\ODM\MongoDB\Cursor;
use Doctrine\ODM\MongoDB\DocumentRepository;
use Doctrine\ODM\MongoDB\MongoDBException;

class PubRepository extends DocumentRepository implements PubRepositoryInterface
{
    /**
     * {@inheritdoc}
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

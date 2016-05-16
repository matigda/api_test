<?php

namespace ApiBundle\Provider;

use ApiBundle\Cache\Cache;
use ApiBundle\Document\Pub;
use ApiBundle\Exception\PubNotFoundException;
use ApiBundle\Repository\PubRepositoryInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\Persistence\ObjectRepository;
use Symfony\Component\HttpFoundation\Request;

class PubProvider
{
    /**
     * @var ObjectRepository
     */
    private $pubRepository;

    /**
     * @var ObjectManager
     */
    private $objectManager;

    /**
     * @var LocalizationProvider
     */
    private $localizationProvider;

    /**
     * @param ObjectManager $objectManager
     * @param PubRepositoryInterface $pubRepository
     * @param Cache $cache
     * @param LocalizationProvider $localizationProvider
     */
    public function __construct(
        ObjectManager $objectManager,
        PubRepositoryInterface $pubRepository,
        Cache $cache,
        LocalizationProvider $localizationProvider
    ) {
        $this->objectManager = $objectManager;
        $this->pubRepository = $pubRepository;
        $this->cache = $cache;
        $this->localizationProvider = $localizationProvider;
    }

    /**
     * @param Request $request
     *
     * @return array
     */
    public function getPubs(Request $request)
    {
        list($lat, $long, $radius) = $this->localizationProvider->getLocalizationData($request);
        $identifier = $lat . $long . $radius;

        if (false === $pubs = $this->cache->get($identifier)) {
            $pubs = $this->pubRepository->getPubsNearCoordinatesWithinRadius($lat, $long, $radius);

            $this->cache->save($identifier, $pubs);
        }

        return $pubs;
    }

    /**
     * @param string $id
     * @param bool   $getPersisted
     *
     * @return Pub
     */
    public function getPub($id, $getPersisted = false)
    {
        if (false === $pub = $this->cache->get($id)) {
            $pub = $this->getPubFromRepository($id);

            $this->cache->save($id, $pub);
        }

        return $this->mergeIfRequired($pub, $getPersisted);
    }

    /**
     * @param string $id
     *
     * @return Pub
     *
     * @throws PubNotFoundException
     */
    private function getPubFromRepository($id)
    {
        $pub = $this->pubRepository->find($id);

        if ($pub === null) {
            throw new PubNotFoundException(sprintf('Pub with id %s was not found', $id));
        }

        return $pub;
    }

    /**
     * @param Pub  $pub
     * @param bool $getPersisted
     *
     * @return Pub
     */
    private function mergeIfRequired(Pub $pub, $getPersisted)
    {
        if ($getPersisted === true && !$this->objectManager->contains($pub)) {
            $pub = $this->objectManager->merge($pub);
        }

        return $pub;
    }
}

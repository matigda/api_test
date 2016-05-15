<?php

namespace ApiBundle\Cache;

use ApiBundle\Provider\HashProvider;
use Doctrine\Common\Cache\CacheProvider;

class Cache
{
    /**
     * @var HashProvider
     */
    private $hashProvider;

    /**
     * @var CacheProvider
     */
    private $cacheProvider;

    /**
     * @var int
     */
    private $lifetime;

    /**
     * @param CacheProvider $cacheProvider
     * @param HashProvider  $hashProvider
     * @param int           $lifetime
     */
    public function __construct(CacheProvider $cacheProvider, HashProvider $hashProvider, $lifetime)
    {
        $this->hashProvider = $hashProvider;
        $this->cacheProvider = $cacheProvider;
        $this->lifetime = $lifetime;
    }

    /**
     * @param string $identifier
     *
     * @return false|mixed
     */
    public function get($identifier)
    {
        $hash = $this->hashProvider->getHash($identifier);

        return $this->cacheProvider->fetch($hash);
    }

    /**
     * @param string $identifier
     * @param mixed  $content
     *
     * @return bool
     */
    public function save($identifier, $content)
    {
        $hash = $this->hashProvider->getHash($identifier);

        return $this->cacheProvider->save($hash, $content, $this->lifetime);
    }
}

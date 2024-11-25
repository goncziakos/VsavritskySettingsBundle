<?php

namespace Vsavritsky\SettingsBundle\Cache;

use Doctrine\Common\Cache\CacheProvider;

class DoctrineCache implements AdapterCacheInterface
{
    public function __construct(private CacheProvider $provider)
    {
    }

    /**
     * {@inheritdoc}
     */
    function get($key, $default = null)
    {
        $value = $this->provider->fetch($key);
        return $value !== false ? $value : $default;
    }

    /**
     * {@inheritdoc}
     */
    function set($key, $value, $ttl = 0)
    {
        return $item = $this->provider->save($key, $value, $ttl);
    }

    /**
     * {@inheritdoc}
     */
    function delete($key)
    {
        return $this->provider->delete($key);
    }
}

<?php

namespace Vsavritsky\SettingsBundle\Cache;

use Symfony\Component\Cache\Simple\AbstractCache;

class SimpleCache implements AdapterCacheInterface
{
    public function __construct(private AbstractCache $adapter)
    {
    }

    /**
     * {@inheritdoc}
     */
    function get($key, $default = null)
    {
        return $this->adapter->get($key, $default);
    }

    /**
     * {@inheritdoc}
     */
    function set($key, $value, $ttl = 0)
    {
        return $item = $this->adapter->set($key, $value, $ttl);
    }

    /**
     * {@inheritdoc}
     */
    function delete($key)
    {
        return $this->adapter->delete($key);
    }
}

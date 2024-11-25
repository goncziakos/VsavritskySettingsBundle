<?php

namespace Vsavritsky\SettingsBundle\Cache;

use Symfony\Component\Cache\Adapter\AdapterInterface;

class SymfonyCache implements AdapterCacheInterface
{
    public function __construct(private AdapterInterface $adapter)
    {
    }

    /**
     * {@inheritdoc}
     */
    function get($key, $default = null)
    {
        $cacheItem = $this->adapter->getItem($key);
        return $cacheItem->isHit() ? $cacheItem->get() : $default;
    }

    /**
     * {@inheritdoc}
     */
    function set($key, $value, $ttl = 0)
    {
        $ttl = (int)$ttl;
        $item = $this->adapter->getItem($key)->set($value);
        if ($ttl > 0) {
            $date = new \DateTime("+{$ttl}seconds");
            $item->expiresAt($date);
        }
        return $this->adapter->save($item);
    }

    /**
     * {@inheritdoc}
     */
    function delete($key)
    {
        return $this->adapter->deleteItem($key);
    }
}

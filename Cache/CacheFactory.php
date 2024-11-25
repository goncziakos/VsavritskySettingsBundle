<?php

namespace Vsavritsky\SettingsBundle\Cache;

use Doctrine\Common\Cache\CacheProvider;
use Symfony\Component\Cache\Adapter\AdapterInterface;
use Symfony\Component\Cache\Simple\AbstractCache;
use Symfony\Component\DependencyInjection\ContainerInterface;

class CacheFactory
{
    public static function createByName(string $serviceName, ContainerInterface $container): ?AdapterCacheInterface
    {
        $service = $container->get($serviceName, ContainerInterface::NULL_ON_INVALID_REFERENCE);
        return is_null($service) ? null : self::create($service);
    }

    public static function create(object $service): ?AdapterCacheInterface
    {
        if ($service instanceof AdapterInterface) {
            return new SymfonyCache($service);
        } elseif ($service instanceof CacheProvider) {
            return new DoctrineCache($service);
        } elseif ($service instanceof AbstractCache) {
            return new SimpleCache($service);
        }
        return null;
    }
}

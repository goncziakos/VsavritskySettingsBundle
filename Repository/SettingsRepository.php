<?php

namespace Vsavritsky\SettingsBundle\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Vsavritsky\SettingsBundle\Entity\Settings;

class SettingsRepository extends ServiceEntityRepository
{
    public function getGroup(string $name): array
    {
        return $this->createQueryBuilder('s')
            ->innerJoin('s.category', 'c')
            ->where('c.name = :name')
            ->setParameter('name', $name)
            ->getQuery()
            ->getResult();
    }

    /**
     * @param Settings $setting
     */
    public function save(Settings $setting)
    {
        $this->_em->persist($setting);
        $this->_em->flush();
    }
}

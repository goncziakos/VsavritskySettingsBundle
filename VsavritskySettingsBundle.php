<?php

namespace Vsavritsky\SettingsBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Doctrine\DBAL\Types\Type as DoctrineType;

class VsavritskySettingsBundle extends Bundle
{
    public function boot(): void
    {
        if (!DoctrineType::hasType('VsavritskySettingsEnumType')) {
            DoctrineType::addType('VsavritskySettingsEnumType', 'Vsavritsky\\SettingsBundle\\DBAL\\SettingsType');
        }
    }
}

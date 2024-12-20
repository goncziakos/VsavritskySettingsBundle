<?php

namespace Vsavritsky\SettingsBundle\DBAL;

use Fresh\DoctrineEnumBundle\DBAL\Types\AbstractEnumType;

class SettingsType extends AbstractEnumType
{
    const Boolean = 'boolean';
    const Integer = 'int';
    const Float   = 'float';
    const String  = 'string';
    const Text    = 'text';
    const Html    = 'html';

    protected static array $choices  = array(
        self::Boolean => 'Boolean',
        self::Integer => 'Integer',
        self::Float   => 'Float',
        self::String  => 'String',
        self::Text    => 'Text',
        self::Html    => 'Html',
    );

    protected string $name = 'VsavritskySettingsEnumType';
}

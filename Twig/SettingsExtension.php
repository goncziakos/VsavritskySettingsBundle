<?php

namespace Vsavritsky\SettingsBundle\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;
use Vsavritsky\SettingsBundle\Service\Settings;

class SettingsExtension extends AbstractExtension
{
    public function __construct(private Settings $settings)
    {
    }

    public function getFunctions(): array
    {
        return array(
            new TwigFunction('settings', array($this, 'getSettings')),
            new TwigFunction('settings_group', array($this, 'getSettingsGroup')),
        );
    }

    public function getSettings($name, $subname = null)
    {
        return $this->settings->get($name, $subname);
    }

    public function getSettingsGroup($name): ?array
    {
        return $this->settings->group($name);
    }
}

<?php

namespace Vsavritsky\SettingsBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Vsavritsky\SettingsBundle\DBAL\SettingsType;

class Settings extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $valueType = method_exists('Symfony\Component\Form\AbstractType', 'getBlockPrefix')
            ? 'Vsavritsky\SettingsBundle\Form\Type\SettingValueType'
            : 'setting_value';
        $builder
            ->add('category', 'entity', array('class' => 'VsavritskySettingsBundle:Category', 'property_path' => 'name', 'required' => false))
            ->add('name', 'text')
            ->add('type', 'choice', array('choices' => SettingsType::getChoices()))
            ->add('value', $valueType)
            ->add('comment', 'textarea', array('required' => false))
            ->add('save', 'submit')
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $this->configureOptions($resolver);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Vsavritsky\\SettingsBundle\\Entity\\Settings',
        ));
    }

    public function getName()
    {
        return 'vsavritsky_settings';
    }
}

<?php

namespace Vsavritsky\SettingsBundle\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vsavritsky\SettingsBundle\DBAL\SettingsType;
use Vsavritsky\SettingsBundle\Entity\Category as CategoryEntity;
use Vsavritsky\SettingsBundle\Entity\Settings as SettingsEntity;
use Vsavritsky\SettingsBundle\Form\Type\SettingValueType;

class Settings extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('category', EntityType::class, array('class' => CategoryEntity::class, 'choice_label' => 'name', 'required' => false))
            ->add('name', TextType::class)
            ->add('type', ChoiceType::class, array('choices' => array_flip(SettingsType::getChoices())))
            ->add('value', SettingValueType::class)
            ->add('comment', TextareaType::class, array('required' => false))
            ->add('save', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(array(
            'data_class' => SettingsEntity::class,
        ));
    }

    public function getBlockPrefix(): string
    {
        return 'vsavritsky_settings';
    }
}

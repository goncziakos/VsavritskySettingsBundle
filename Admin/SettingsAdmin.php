<?php

namespace Vsavritsky\SettingsBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\Type\ModelListType;
use Sonata\AdminBundle\Show\ShowMapper;

use Symfony\Component\DependencyInjection\ParameterBag\ContainerBagInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Vsavritsky\SettingsBundle\DBAL\SettingsType;
use Vsavritsky\SettingsBundle\Entity\Settings;
use Vsavritsky\SettingsBundle\Entity\Category;
use Vsavritsky\SettingsBundle\Service\Settings as SettingsService;

class SettingsAdmin extends AbstractAdmin
{
    private ParameterBagInterface $parameterBag;

    private SettingsService $settings;

    public function configureListFields(ListMapper $listMapper): void
    {
        $useCategoryComment = $this->parameterBag->get('vsavritsky_settings.use_category_comment');

        $listMapper
            ->addIdentifier('name')
            ->add('category', null, array(
                'associated_property' => function(Category $cat) use ($useCategoryComment) {
                    return $useCategoryComment && $cat->getComment() ? $cat->getComment() : $cat->getName();
                },
                'sortable' => true,
                'sort_field_mapping' => array('fieldName' => 'name'),
                'sort_parent_association_mappings' => array(array('fieldName' => 'category'))
            ))
            ->add('type', ChoiceType::class, array('choices' => SettingsType::getReadableValues(), 'catalogue' => 'messages'))
            ->add('value', null, array('template' => '@VsavritskySettings/Admin/list_value.html.twig'))
            ->add('comment')
        ;
    }

    public function configureFormFields(FormMapper $formMapper): void
    {
        $valueType = $this->isNewForm()
            ? 'Vsavritsky\SettingsBundle\Form\Type\SettingValueType'
            : 'setting_value';
        $formMapper
            ->add('name')
            ->add('category', ModelListType::class)
            ->add('type', ChoiceType::class, array(
                'choices' => SettingsType::getChoices(),
                'attr' => array('data-sonata-select2'=>'false'),
            ))
            ->add('value', $valueType)
            ->add('comment')
        ;
    }

    public function configureDatagridFilters(DatagridMapper $datagridMapper): void
    {
        $useCategoryComment = $this->parameterBag->get('vsavritsky_settings.use_category_comment');

        $categoryOptions = $this->isNewForm()
            ? array(
                'choice_label' => function (Category $cat) use ($useCategoryComment) {
                    return $useCategoryComment && $cat->getComment() ? $cat->getComment() : $cat->getName();
                },
            ) : array();
        $datagridMapper
            ->add('category', null, [
                'field_options' => $categoryOptions
            ])
            ->add('name')
            ->add('type', null, [
                'field_type' => ChoiceType::class,
                'field_options' => [
                    'choices' => SettingsType::getChoices(),
                ],
            ])
        ;
    }

    public function configureShowFields(ShowMapper $showMapper): void
    {
        $showMapper
            ->add('name')
            ->add('type')
            ->add('value')
            ->add('comment')
        ;
    }

    /**
     * @param Settings $object
     */
    public function postPersist($object): void
    {
        $this->clearCache($object);
    }

    /**
     * @param Settings $object
     */
    public function postUpdate($object): void
    {
        $this->clearCache($object);
    }

    /**
     * @param Settings $object
     */
    public function preRemove($object): void
    {
        $this->clearCache($object);
    }

    public function configure(): void
    {
        $this->setFormTheme(array_merge(
            $this->getFormTheme(),
            array('@VsavritskySettings/Form/setting_value_edit.html.twig')
        ));
    }

    public function setParameterBag(ParameterBagInterface $parameterBag): void
    {
        $this->parameterBag = $parameterBag;
    }

    public function setSettings(SettingsService $settings): void
    {
        $this->settings = $settings;
    }

    /**
     * @param Settings $object
     */
    private function clearCache(Settings $object): void
    {
        $this->settings->clearCache($object->getName());
        if ($object->getCategory()) {
            $this->settings->clearGroupCache($object->getCategory()->getName());
        }
    }

    /**
     * @return bool
     */
    protected function isNewForm()
    {
        return method_exists('Symfony\Component\Form\AbstractType', 'getBlockPrefix');
    }
}

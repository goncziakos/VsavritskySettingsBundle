<?php

namespace Vsavritsky\SettingsBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Show\ShowMapper;

use Vsavritsky\SettingsBundle\Entity\Category;
use Vsavritsky\SettingsBundle\Service\Settings as SettingsService;

class CategoryAdmin extends AbstractAdmin
{
    private SettingsService $settings;

    public function configureListFields(ListMapper $listMapper): void
    {
        $listMapper
            ->addIdentifier('name')
            ->add('comment')
        ;
    }

    public function configureFormFields(FormMapper $formMapper): void
    {
        $formMapper
            ->add('name')
            ->add('comment')
        ;
    }

    public function configureDatagridFilters(DatagridMapper $datagridMapper): void
    {
        $datagridMapper
            ->add('name')
        ;
    }

    public function configureShowFields(ShowMapper $showMapper): void
    {
        $showMapper
            ->add('name')
            ->add('comment')
        ;
    }

    /**
     * @param Category $object
     */
    public function postPersist($object): void
    {
        $this->clearCache($object);
    }

    /**
     * @param Category $object
     */
    public function postUpdate($object): void
    {
        $this->clearCache($object);
    }

    /**
     * @param Category $object
     */
    public function preRemove($object): void
    {
        $this->clearCache($object);
    }

    public function setSettings(SettingsService $settings): void
    {
        $this->settings = $settings;
    }

    /**
     * @param Category $object
     */
    private function clearCache(Category $object): void
    {
        $this->settings->clearGroupCache($object->getName());
    }
}

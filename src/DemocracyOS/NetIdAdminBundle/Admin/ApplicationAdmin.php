<?php

namespace DemocracyOS\NetIdAdminBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;

class ApplicationAdmin extends Admin
{
    protected $baseRoutePattern = 'application';

    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->remove('batch');
    }

    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('name')
            ->add('description')
        ;
        if ($this->getSubject() && $this->getSubject()->getId())
        {
            $formMapper
                ->add('publicId', 'text', array('read_only' => true))
                ->add('secret');
        }
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('name')
            ->add('description')
        ;
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('name')
            ->add('description')
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function getExportFormats()
    {
        return array(
            'csv', 'xls'
        );
    }
}

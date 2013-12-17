<?php

namespace DemocracyOS\NetIdAdminBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;

class IdentityApplicationAdmin extends Admin
{
    protected $baseRoutePattern = 'identity-application';

    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('application', 'sonata_type_model', array('btn_add' => false))
            ->add('foreignId')
        ;
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('application')
            ->add('foreignId')
        ;
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('application')
            ->add('foreignId')
        ;
    }
}

<?php

namespace DemocracyOS\NetIdAdminBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;

class AuditAdmin extends Admin
{
    protected $baseRoutePattern = 'audit';
    protected $baseRouteName = 'audit';

    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->add('downloadLog', 'download-log', array(), array('_method' => 'get'));
    }

    protected function configureFormFields(FormMapper $formMapper)
    {
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
    }

    protected function configureListFields(ListMapper $listMapper)
    {
    }
}
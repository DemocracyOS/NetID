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
    protected $datagridValues = array(
        '_sort_order' => 'DESC',
        '_sort_by' => 'datetime'
    );

    protected function configureRoutes(RouteCollection $collection)
    {
        $collection
            ->remove('batch')
            ->remove('create')
        ;
    }

    protected function configureFormFields(FormMapper $formMapper)
    {
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('datetime', null, array('format' => 'd/m/y H:i:s'))
            ->add('ip')
            ->add('browserData')
            ->add('username')
            ->add('rolesList', 'text')
            ->add('action')
            ->add('object')
            ->remove('batch')
        ;
    }

    /**
     * @return array
     */
    public function getExportFields()
    {
        return array(
            'datetime',
            'ip',
            'browserData',
            'username',
            'rolesList',
            'action',
            'object'
        );
    }
}
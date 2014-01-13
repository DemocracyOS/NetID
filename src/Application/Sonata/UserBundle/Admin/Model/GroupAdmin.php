<?php

namespace Application\Sonata\UserBundle\Admin\Model;

use Sonata\UserBundle\Admin\Model\GroupAdmin as Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Route\RouteCollection;

class GroupAdmin extends Admin
{
    protected $baseRoutePattern = 'group';
 
    protected function configureRoutes(RouteCollection $collection)
    {
        parent::configureRoutes($collection);
        $collection->remove('batch');
    }

    /**
     * {@inheritdoc}
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('name')
            ->add('rolesList', 'text', array('label' => 'fasd'))
            ->remove('batch')
        ;
    }
}

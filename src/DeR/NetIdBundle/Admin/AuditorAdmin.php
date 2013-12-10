<?php
namespace DeR\NetIdBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\AdminBundle\Show\ShowMapper;

class AuditorAdmin extends Admin
{
    protected $baseRoutePattern = 'auditor';

    public function createQuery($context = 'list')
    {
        $query = parent::createQuery($context);
        $query->getQueryBuilder()->orderBy("o.date", "DESC");
        return $query;
    }

    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->remove('batch');
        $collection->remove('create');
    }
    
	// Fields to be shown on create/edit forms
    protected function configureFormFields(FormMapper $formMapper)
    {
    }

    // Fields to be shown on filter forms
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
    }

    // Fields to be shown on show
    protected function configureShowFields(ShowMapper $filter)
    {
    }

    // Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('subject', null, array('route' => array('name' => 'show')))
            ->add('performedAction')
            ->add('object', null, array('template' => 'DeRNetIdBundle:Default:list_orm_many_to_one.html.twig'))
            ->add('_action', 'actions', array(
                'actions' => array(
                    'show' => array(),
                    'edit' => array(),
                    'delete' => array(),
                )
            ))
            ->remove('batch');
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
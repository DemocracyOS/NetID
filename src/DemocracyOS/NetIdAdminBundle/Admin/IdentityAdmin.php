<?php

namespace DemocracyOS\NetIdAdminBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;

class IdentityAdmin extends Admin
{
    protected $baseRoutePattern = 'identity';

    protected function configureRoutes(RouteCollection $collection)
    {
        $collection
            ->remove('batch')
            ->add('identityValidateSearch', 'validate', array(), array('_method' => 'get'))
            ->add('identityValidateSearchPost', 'validate', array(), array('_method' => 'post'))
            ->add('validateIdentity', $this->getRouterIdParameter(). '/validate-identity', array(), array('_method' => 'get'))
            ->add('validateIdentityPost', $this->getRouterIdParameter(). '/validate-identity', array(), array('_method' => 'post'))
            ->add('invalidateIdentity', $this->getRouterIdParameter(). '/invalidate-identity', array(), array('_method' => 'get'))
            ->add('invalidateIdentityPost', $this->getRouterIdParameter(). '/invalidate-identity', array(), array('_method' => 'post'))
            ->add('suspicious', $this->getRouterIdParameter().'/suspicious')
            ->add('mark_suspicious', $this->getRouterIdParameter().'/mark_suspicious')
            ->add('unsuspicious', $this->getRouterIdParameter().'/unsuspicious')
            ->add('mark_unsuspicious', $this->getRouterIdParameter().'/mark_unsuspicious')
        ;
    }

    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('firstname')
            ->add('lastname')
            ->add('birthday', 'birthday', array('format' => 'ddMMMMyyyy'))
            ->add('legalIdType')
            ->add('legalId')
            ->setHelps(array(
               'legalId' => 'Example: 33333333'
            ))
            ->add('district')
            ->add('applications', 'sonata_type_collection', array(), array(
                'edit' => 'inline',
                'inline' => 'table',
                'sortable' => 'position',
            ))
        ;
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('firstname')
            ->add('lastname')
        ;
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('firstname')
            ->add('lastname')
            ->add('birthday')
            ->remove('batch')
            ->add('_action', 'actions', array(
                    'actions' => array(
                        'show' => array(),
                        'edit' => array(),
                        'delete' => array(),
                        'suspicious' => array('template' => 'DemocracyOSNetIdAdminBundle:Identity:suspiciousButton.html.twig'),
                    )
                )
            )
        ;
    }

    public function prePersist($identity)
    {
        foreach ($identity->getApplications() as $application) {
            $application->setIdentity($identity);
        }
    }

    public function preUpdate($identity)
    {
        foreach ($identity->getApplications() as $application) {
            $application->setIdentity($identity);
        }
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

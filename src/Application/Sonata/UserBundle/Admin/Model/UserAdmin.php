<?php

namespace Application\Sonata\UserBundle\Admin\Model;

use Sonata\UserBundle\Admin\Model\UserAdmin as Admin;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Route\RouteCollection;

class UserAdmin extends Admin
{
    protected $baseRoutePattern = 'user';

    protected function configureRoutes(RouteCollection $collection)
    {
        parent::configureRoutes($collection);
        $collection->remove('batch');
    }

    /**
     * {@inheritdoc}
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->with('General')
                ->add('username')
                ->add('email')
                ->add('plainPassword', 'password', array(
                    'required' => (!$this->getSubject() || is_null($this->getSubject()->getId()))
                ))
            ->end()
            ->with('Groups')
                ->add('groups', 'sonata_type_model', array(
                    'required' => false,
                    'expanded' => true,
                    'multiple' => true
                ))
            ->end()
        ;

        if ($this->getSubject() && !$this->getSubject()->hasRole('ROLE_SUPER_ADMIN')) {
            $formMapper
                ->with('Management')
                    ->add('realRoles', 'sonata_security_roles', array(
                        'label'    => 'form.label_roles',
                        'expanded' => true,
                        'multiple' => true,
                        'required' => false
                    ))
                    ->add('locked', null, array('required' => false))
                    ->add('expired', null, array('required' => false))
                    ->add('enabled', null, array('required' => false))
                    ->add('credentialsExpired', null, array('required' => false))
                ->end()
            ;
        }
    }

    /**
     * {@inheritdoc}
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        parent::configureListFields($listMapper);
        $listMapper
            ->remove('batch')
        ;
    }
}

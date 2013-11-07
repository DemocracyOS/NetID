<?php
namespace PdR\NetIdBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Validator\ErrorElement;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\DoctrineORMAdminBundle\Datagrid\ProxyQuery;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class UserAdmin extends Admin
{
    protected $em;
    protected $baseRoutePattern = 'user';

    public function setEntityManager($em)
    {
        $this->em = $em;
    }
    
    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->remove('batch');
    }

    public function createQuery($context = 'list')
    {
        $query = parent::createQuery($context);
        if (!$this->isGranted('ROLE_SUPER_ADMIN')) {
            $query = parent::createQuery($context);
            $query->andWhere(
                $query->getQueryBuilder()->expr()->not($query->getQueryBuilder()->expr()->like("o.roles", "'%ROLE_SUPER_ADMIN%'"))
                )
            ;
        }
        return $query;
    }

    // Fields to be shown on create/edit forms
    protected function configureFormFields(FormMapper $formMapper)
    {
        if ($this->getSubject()->isSuperAdmin() && !$this->isGranted('ROLE_SUPER_ADMIN')) {
            throw new AccessDeniedException();
        }
        $choices = array(
            'ROLE_STAFF' => 'Staff'
        ,   'ROLE_ADMIN' => 'Admin'
        ,   'ROLE_SUPER_ADMIN' => 'Super admin'
        );
        $formMapper
            ->add('name')
            ->add('lastname')
            ->add('email')
            ->add('birthdate', 'birthday', array('format' => 'ddMMyyyy'))
            ->add('legalIdType')
            ->add('legalId')
            ->setHelps(array(
               'legalId' => 'Example: 33333333'
            ))
            ->add('district')
            ->add('clients', 'sonata_type_collection', array('by_reference' => false), 
                array('edit' => 'inline', 'inline' => 'table'))
            ;
        if ($this->isGranted('ROLE_SUPER_ADMIN')) {
            $formMapper->add('roles', 'choice', array('multiple'=>true, 'expanded' => true, 'choices' => $choices));
        }
    }

    // Fields to be shown on show
    protected function configureShowFields(ShowMapper $filter)
    {
        $filter
            ->add('name')
            ->add('lastname')
            ->add('email')
            ->add('birthdate', null, array('format' => 'd/m/Y'))
            ->add('legalIdType')
            ->add('legalId');
    }

    public function prePersist($user)
    {
        $user->setPlainPassword('123456');
        $user->setEnabled(true);
        $this->persistClients($user);
    }

    public function preUpdate($user)
    {
        $this->persistClients($user);
    }

    protected function persistClients($user)
    {
        $clients = $user->getClients();
        $user->clearClients();
        $this->em->persist($user);
        $this->em->flush();
        foreach ($clients as $client) {
            $user->addClient($client);
            $client->setUser($user);
            $this->em->persist($client);
        }
        $this->em->persist($user);
        $this->em->flush();
    }

    // Fields to be shown on filter forms
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('email')
            ->add('name')
            ->add('lastname')
        ;
    }

    // Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('legalId')
            ->add('legalIdType')
            ->add('name')
            ->add('email')
            ->add('lastname')
            ->remove('batch')
            ->add('_action', 'actions', array(
                'actions' => array(
                    'show' => array(),
                    'edit' => array(),
                    'delete' => array(),
                )
            ));
        ;
    }
}

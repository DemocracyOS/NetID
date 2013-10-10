<?php
namespace PdR\NetIdBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Validator\ErrorElement;
use Sonata\AdminBundle\Route\RouteCollection;

class UserAdmin extends Admin
{
    protected $em;

    public function setEntityManager($em)
    {
        $this->em = $em;
    }

    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->remove('batch');
    }

    // Fields to be shown on create/edit forms
    protected function configureFormFields(FormMapper $formMapper)
    {
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
            ->add('staff', null, array('required' => false));
    }

    public function prePersist($user)
    {
        $user->setPassword('');
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
            ->addIdentifier('email')
            ->add('name')
            ->add('lastname')
            ->remove('batch')
            ->add('_action', 'actions', array(
                'actions' => array(
                    'edit' => array(),
                    'delete' => array(),
                )
            ));
        ;
    }
}

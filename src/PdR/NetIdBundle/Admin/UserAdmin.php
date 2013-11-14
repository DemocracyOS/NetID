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
use PdR\NetIdBundle\Entity\UserLog;

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
        $collection->add('suspicious', $this->getRouterIdParameter().'/suspicious');
        $collection->add('mark_suspicious', $this->getRouterIdParameter().'/mark_suspicious');
        $collection->add('unsuspicious', $this->getRouterIdParameter().'/unsuspicious');
        $collection->add('mark_unsuspicious', $this->getRouterIdParameter().'/mark_unsuspicious');
    }

    public function createQuery($context = 'list')
    {
        $query = parent::createQuery($context);
        if (!$this->isGranted('ROLE_SUPER_ADMIN')) {
            $query = parent::createQuery($context);
            $query->getQueryBuilder()->leftJoin("o.userRoles", "r")
                                    ->andWhere(
                                        $query->getQueryBuilder()->expr()->notIn('r.name', array('ROLE_SUPER_ADMIN', 'ROLE_ADMIN'))
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
            $formMapper->with('Security')
                        ->add('username')
                        ->add('plainPassword', 'password', array('required' => false))
                        ->add('userRoles', 'sonata_type_model', array('multiple'=>true, 'expanded' => true))
                        ->end();
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

    public function postUpdate($user)
    {
        $this->logUser($user, 'UPD');
    }

    public function postInsert($user)
    {
        $this->logUser($user, 'INS');
    }

    protected function logUser($user, $action)
    {
        $userLog = new UserLog($user);
        $securityContext = $this->getConfigurationPool()->getContainer()->get('security.context');
        $userLog->setUser($securityContext->getToken()->getUser());
        $userLog->setPerformedAction($action);
        $this->em->persist($userLog);
        $this->em->flush();
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
            ->add('legalId')
        ;
    }

    // Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('legalId')
            ->add('legalIdType');
        if ($this->isGranted('ROLE_SUPER_ADMIN'))
        {
            $listMapper->add('username');
        }
        $listMapper
            ->add('name')
            ->add('email')
            ->add('lastname')
            ->remove('batch')
            ->add('_action', 'actions', array(
                'actions' => array(
                    'show' => array(),
                    'edit' => array(),
                    'delete' => array(),
                    'suspicious' => array('template' => 'PdRNetIdBundle:UserAdmin:suspiciousButton.html.twig'),
                )
            ));
        ;
    }

    public function getExportFields()
    {
        $fields = array('legalIdType', 'legalId');
        if ($this->isGranted('ROLE_SUPER_ADMIN'))
        {
            $fields[] = 'username';
        }
        $fields = array_merge($fields, array('name', 'email', 'lastname'));
        return $fields;
    }
}

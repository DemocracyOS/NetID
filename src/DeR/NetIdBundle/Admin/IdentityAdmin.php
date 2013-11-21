<?php
namespace DeR\NetIdBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Validator\ErrorElement;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\DoctrineORMAdminBundle\Datagrid\ProxyQuery;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use DeR\NetIdBundle\Entity\IdentityLog;

class IdentityAdmin extends Admin
{
    protected $em;
    protected $baseRoutePattern = 'identity';

    public function setEntityManager($em)
    {
        $this->em = $em;
    }

    /**
     * {@inheritdoc}
     */
    public function configure()
    {
        $filters = $this->em->getFilters();
        $filters->enable('softdeleteable');
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
                                        $query->getQueryBuilder()->expr()->orX(
                                            $query->getQueryBuilder()->expr()->isNull('r.name'),
                                            $query->getQueryBuilder()->expr()->notIn('r.name', array('ROLE_SUPER_ADMIN', 'ROLE_ADMIN'))
                                      )
                                    )

            ;
        }
        return $query;
    }

    // Fields to be shown on create/edit forms
    protected function configureFormFields(FormMapper $formMapper)
    {
        if (($this->getSubject()->isSuperAdmin() || $this->getSubject()->isAdmin()) && !$this->isGranted('ROLE_SUPER_ADMIN')) {
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
                        ->add('username', null, array('required' => false, 'attr' => array('autocomplete' => 'off')))
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

    public function prePersist($identity)
    {
        $identity->setEnabled(true);
        $this->persistClients($identity);
    }

    public function preUpdate($identity)
    {
        $this->persistClients($identity);
    }

    public function postUpdate($identity)
    {
        $this->logIdentity($identity, 'UPD');
    }

    public function postPersist($identity)
    {
        $this->logIdentity($identity, 'INS');
    }

    public function postRemove($identity)
    {
        $this->logIdentity($identity, 'DEL');
    }

    public function logIdentity($object, $action)
    {
        $securityContext = $this->getConfigurationPool()->getContainer()->get('security.context');
        $subject = $securityContext->getToken()->getUser();
        $identityLog = new IdentityLog($subject, $action, $object);
        $this->em->persist($identityLog);
        $this->em->flush();
    }

    protected function persistClients($identity)
    {
        $clients = $identity->getClients();
        $identity->clearClients();
        $this->em->persist($identity);
        $this->em->flush();
        foreach ($clients as $client) {
            $identity->addClient($client);
            $client->setUser($identity);
            $this->em->persist($client);
        }
        $this->em->persist($identity);
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
                    'suspicious' => array('template' => 'DeRNetIdBundle:UserAdmin:suspiciousButton.html.twig'),
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

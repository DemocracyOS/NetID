<?php

namespace DeR\NetIdBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use DeR\NetIdBundle\Entity\Action;
use DeR\NetIdBundle\Entity\Role;

class Roles implements FixtureInterface, OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $userActions = array();
        $userActions[] = $userList = new Action('ROLE_SONATA_ADMIN_IDENTITY_LIST');
        $userActions[] = $userView = new Action('ROLE_SONATA_ADMIN_IDENTITY_VIEW');
        $userActions[] = $userEdit = new Action('ROLE_SONATA_ADMIN_IDENTITY_EDIT');
        $userActions[] = $userCreate = new Action('ROLE_SONATA_ADMIN_IDENTITY_CREATE');
        $userActions[] = $userDelete = new Action('ROLE_SONATA_ADMIN_IDENTITY_DELETE');
        $userActions[] = $userExport = new Action('ROLE_SONATA_ADMIN_IDENTITY_EXPORT');
        
        $userActions[] = $roleList = new Action('ROLE_SONATA_ADMIN_ROLE_LIST');
        $userActions[] = $roleView = new Action('ROLE_SONATA_ADMIN_ROLE_VIEW');
        $userActions[] = new Action('ROLE_SONATA_ADMIN_ROLE_EDIT');
        $userActions[] = new Action('ROLE_SONATA_ADMIN_ROLE_CREATE');
        $userActions[] = new Action('ROLE_SONATA_ADMIN_ROLE_DELETE');
        $userActions[] = new Action('ROLE_SONATA_ADMIN_ROLE_EXPORT');

        $userActions[] = $actionList = new Action('ROLE_SONATA_ADMIN_ACTION_LIST');
        $userActions[] = $actionView = new Action('ROLE_SONATA_ADMIN_ACTION_VIEW');
        $userActions[] = new Action('ROLE_SONATA_ADMIN_ACTION_EDIT');
        $userActions[] = new Action('ROLE_SONATA_ADMIN_ACTION_CREATE');
        $userActions[] = new Action('ROLE_SONATA_ADMIN_ACTION_DELETE');
        $userActions[] = new Action('ROLE_SONATA_ADMIN_ACTION_EXPORT');

        $userActions[] = $identityLogList = new Action('ROLE_SONATA_ADMIN_IDENTITY_LOG_LIST');
        $userActions[] = $identityLogView = new Action('ROLE_SONATA_ADMIN_IDENTITY_LOG_VIEW');
        $userActions[] = $identityLogExport = new Action('ROLE_SONATA_ADMIN_IDENTITY_LOG_EXPORT');

        foreach ($userActions as $userAction) {
            $manager->persist($userAction);
        }
        $manager->flush();

        $roles = array();
        $actionRepository = $manager->getRepository('DeRNetIdBundle:Action');
        $actions = $actionRepository->findAll();
        $roleSuperAdmin = new Role('ROLE_SUPER_ADMIN');
        foreach ($actions as $action) {
            $roleSuperAdmin->addAction($action);
        }
        $roles[] = $roleSuperAdmin;
        $admin = new Role('ROLE_ADMIN');
        $admin->addAction($userList);
        $admin->addAction($userView);
        $admin->addAction($userExport);
        $admin->addAction($userEdit);
        $admin->addAction($userCreate);
        $admin->addAction($userDelete);
        $roles[] = $admin;
        $roles[] = new Role('ROLE_OPERATOR');
        $audit = new Role('ROLE_AUDITOR');
        $audit->addAction($userList);
        $audit->addAction($userView);
        $audit->addAction($userExport);
        $audit->addAction($roleList);
        $audit->addAction($roleView);
        $audit->addAction($actionList);
        $audit->addAction($actionView);
        $audit->addAction($identityLogList);
        $audit->addAction($identityLogView);
        $audit->addAction($identityLogExport);
        $roles[] = $audit;

        foreach ($roles as $role) {
        	$manager->persist($role);
        }
        $manager->flush();
    }

    public function getOrder()
    {
        return 44;
    }
}
<?php

namespace PdR\NetIdBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use PdR\NetIdBundle\Entity\Action;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use PdR\NetIdBundle\Entity\Role;

class Roles implements FixtureInterface, OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $userActions = array();
        $userActions[] = $userList = new Action('ROLE_SONATA_ADMIN_USER_LIST');
        $userActions[] = $userView = new Action('ROLE_SONATA_ADMIN_USER_VIEW');
        $userActions[] = new Action('ROLE_SONATA_ADMIN_USER_EDIT');
        $userActions[] = new Action('ROLE_SONATA_ADMIN_USER_CREATE');
        $userActions[] = new Action('ROLE_SONATA_ADMIN_USER_DELETE');
        $userActions[] = new Action('ROLE_SONATA_ADMIN_USER_EXPORT');
        
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

        $userActions[] = $userLogList = new Action('ROLE_SONATA_ADMIN_USER_LOG_LIST');
        $userActions[] = $userLogView = new Action('ROLE_SONATA_ADMIN_USER_LOG_VIEW');
        $userActions[] = $userLogExport = new Action('ROLE_SONATA_ADMIN_USER_LOG_EXPORT');

        foreach ($userActions as $userAction) {
            $manager->persist($userAction);
        }
        $manager->flush();

        $roles = array();
        $actionRepository = $manager->getRepository('PdRNetIdBundle:Action');
        $actions = $actionRepository->findAll();
        $roleSuperAdmin = new Role('ROLE_SUPER_ADMIN');
        foreach ($actions as $action) {
            $roleSuperAdmin->addAction($action);
        }
        $roles[] = $roleSuperAdmin;
        $roles[] = new Role('ROLE_ADMIN');
        $roles[] = new Role('ROLE_STAFF');
        $audit = new Role('ROLE_AUDIT');
        $audit->addAction($userList);
        $audit->addAction($userView);
        $audit->addAction($roleList);
        $audit->addAction($roleView);
        $audit->addAction($actionList);
        $audit->addAction($actionView);
        $audit->addAction($userLogList);
        $audit->addAction($userLogView);
        $audit->addAction($userLogExport);
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
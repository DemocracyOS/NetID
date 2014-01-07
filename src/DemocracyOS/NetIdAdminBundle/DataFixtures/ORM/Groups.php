<?php

namespace DemocracyOS\NetIdAdminBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Application\Sonata\UserBundle\Entity\Group;

class Groups implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $repo = $manager->getRepository('ApplicationSonataUserBundle:Group');
        
        $superAdmin = $repo->findOneByName('Super admin');
        $superAdmin = $superAdmin ? $superAdmin : new Group('Super admin');
        $rolesSuperAdmin = array();
        $rolesSuperAdmin[] = 'ROLE_SUPER_ADMIN';
        $superAdmin->setRoles($rolesSuperAdmin);

        $roleOperator = $repo->findOneByName('Operator');
        $roleOperator = $roleOperator ? $roleOperator : new Group('Operator');
        $rolesOperator = array();
        $rolesOperator[] = 'ROLE_SONATA_ADMIN_IDENTITY_VALIDATE';
        $roleOperator->setRoles($rolesOperator);

        $roleAuditor = $repo->findOneByName('Auditor');
        $roleAuditor = $roleAuditor ? $roleAuditor : new Group('Auditor');
        $rolesAuditor = array();
        $rolesAuditor[] = 'ROLE_SONATA_ADMIN_AUDIT_LIST';
        $rolesAuditor[] = 'ROLE_SONATA_ADMIN_AUDIT_EXPORT';
        $roleAuditor->setRoles($rolesAuditor);

        $roleAdmin = $repo->findOneByName('Admin');
        $roleAdmin = $roleAdmin ? $roleAdmin : new Group('Admin');
        $rolesAdmin = array();
        $rolesAdmin[] = 'ROLE_SONATA_ADMIN_IDENTITY_CREATE';
        $rolesAdmin[] = 'ROLE_SONATA_ADMIN_IDENTITY_VIEW';
        $rolesAdmin[] = 'ROLE_SONATA_ADMIN_IDENTITY_LIST';
        $rolesAdmin[] = 'ROLE_SONATA_ADMIN_IDENTITY_EDIT';
        $rolesAdmin[] = 'ROLE_SONATA_ADMIN_IDENTITY_VALIDATE';
        $rolesAdmin[] = 'ROLE_SONATA_ADMIN_IDENTITY_AUDIT';
        $rolesAdmin[] = 'ROLE_SONATA_ADMIN_EMAIL_CREATE';
        $rolesAdmin[] = 'ROLE_SONATA_ADMIN_EMAIL_VIEW';
        $rolesAdmin[] = 'ROLE_SONATA_ADMIN_EMAIL_LIST';
        $rolesAdmin[] = 'ROLE_SONATA_ADMIN_EMAIL_EDIT';
        $rolesAdmin[] = 'ROLE_SONATA_ADMIN_EMAIL_DELETE';
        $rolesAdmin[] = 'ROLE_SONATA_ADMIN_APPLICATION_CREATE';
        $rolesAdmin[] = 'ROLE_SONATA_ADMIN_APPLICATION_VIEW';
        $rolesAdmin[] = 'ROLE_SONATA_ADMIN_APPLICATION_LIST';
        $rolesAdmin[] = 'ROLE_SONATA_ADMIN_APPLICATION_EDIT';
        $rolesAdmin[] = 'ROLE_SONATA_ADMIN_APPLICATION_DELETE';
        $rolesAdmin[] = 'ROLE_SONATA_ADMIN_IDENTITY_APPLICATION_CREATE';
        $rolesAdmin[] = 'ROLE_SONATA_ADMIN_IDENTITY_APPLICATION_VIEW';
        $rolesAdmin[] = 'ROLE_SONATA_ADMIN_IDENTITY_APPLICATION_LIST';
        $rolesAdmin[] = 'ROLE_SONATA_ADMIN_IDENTITY_APPLICATION_EDIT';
        $rolesAdmin[] = 'ROLE_SONATA_ADMIN_IDENTITY_APPLICATION_DELETE';
        $roleAdmin->setRoles($rolesAdmin);

        $manager->persist($superAdmin);
        $manager->persist($roleOperator);
        $manager->persist($roleAuditor);
        $manager->persist($roleAdmin);
        $manager->flush();
    }
}
<?php

namespace DemocracyOS\NetIdAdminBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Application\Sonata\UserBundle\Entity\Group;

class Groups implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $superAdmin = new Group('Super admin');
        $rolesSuperAdmin = array();
        $rolesSuperAdmin[] = 'ROLE_SUPER_ADMIN';
        $superAdmin->setRoles($rolesSuperAdmin);

        $roleOperator = new Group('Operador');
        $rolesOperator = array();
        $rolesOperator[] = 'ROLE_SONATA_ADMIN_IDENTITY_VALIDATE';
        $roleOperator->setRoles($rolesOperator);

        $roleAuditor = new Group('Auditor');
        $rolesAuditor = array();
        $rolesAuditor[] = 'ROLE_SONATA_ADMIN_IDENTITY_AUDIT';
        $roleAuditor->setRoles($rolesAuditor);

        $roleAdmin = new Group('Admin');
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
        $manager->persist($roleAdmin);
        $manager->persist($roleOperator);
        $manager->persist($roleAuditor);
        $manager->flush();
    }
}
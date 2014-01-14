<?php

namespace DemocracyOS\NetIdAdminBundle\Tests\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Application\Sonata\UserBundle\Entity\User;
use Application\Sonata\UserBundle\Entity\Group;

class Users extends AbstractFixture implements OrderedFixtureInterface
{
	public function load(ObjectManager $manager)
	{
		$groupRepository = $manager->getRepository('ApplicationSonataUserBundle:Group');
		$auditorGroup = $groupRepository->findOneByName('Auditor');
		$auditor = new User;
        $auditor->setUsername('auditor');
        $auditor->setPlainPassword('auditor');
        $auditor->setEmail('auditor@auditor.com');
        $auditor->setEnabled(true);
        $auditor->addGroup($auditorGroup);
        $manager->persist($auditor);

		$adminGroup = $groupRepository->findOneByName('Admin');
		$admin = new User;
        $admin->setUsername('admin');
        $admin->setPlainPassword('admin');
        $admin->setEmail('admin@admin.com');
        $admin->setEnabled(true);
        $admin->addGroup($adminGroup);
        $manager->persist($admin);

		$superAdminGroup = $groupRepository->findOneByName('Super admin');
		$superAdmin = new User;
        $superAdmin->setUsername('superAdmin');
        $superAdmin->setPlainPassword('superAdmin');
        $superAdmin->setEmail('superAdmin@superAdmin.com');
        $superAdmin->setEnabled(true);
        $superAdmin->addGroup($superAdminGroup);
        $manager->persist($superAdmin);

		$operatorGroup = $groupRepository->findOneByName('Operator');
		$operator = new User;
        $operator->setUsername('operator');
        $operator->setPlainPassword('operator');
        $operator->setEmail('operator@operator.com');
        $operator->setEnabled(true);
        $operator->addGroup($operatorGroup);
        $manager->persist($operator);

        $manager->flush();
	}

    /**
     * {@inheritDoc}
     */
    public function getOrder()
    {
        return 2;
    }
}
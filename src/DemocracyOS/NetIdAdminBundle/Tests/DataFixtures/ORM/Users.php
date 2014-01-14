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
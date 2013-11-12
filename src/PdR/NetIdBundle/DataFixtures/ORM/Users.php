<?php

namespace PdR\NetIdBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use PdR\NetIdBundle\Entity\User;
use FOS\UserBundle\Model\UserManagerInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class Users implements FixtureInterface, ContainerAwareInterface, OrderedFixtureInterface
{
	private $container;

	public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    public function load(ObjectManager $manager)
    {
        $userManager = $this->container->get('fos_user.user_manager');
        $admin = $userManager->createUser();
		$admin->setUsername('admin');
		$admin->setPlainPassword('admin');
		$admin->setEnabled(true);

		$roleRepository = $manager->getRepository('PdRNetIdBundle:Role');
		$roleSuperAdmin = $roleRepository->findOneByName('ROLE_SUPER_ADMIN');
		$admin->addRole($roleSuperAdmin);

		$userManager->updateUser($admin);
    }

    public function getOrder()
    {
        return 104;
    }
}
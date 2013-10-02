<?php

namespace PdR\NetIdBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use PdR\NetIdBundle\Entity\User;
use FOS\UserBundle\Model\UserManagerInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class Users implements FixtureInterface, ContainerAwareInterface
{
	private $container;

	public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    public function load(ObjectManager $manager)
    {
        $userManager = $this->container->get('fos_user.user_manager');
        $sacha = $userManager->createUser();
		$sacha->setUsername('slifszyc');
		$sacha->setEmail('sacha.lifszyc@gmail.com');
		$sacha->setPlainPassword('123456');
		$sacha->setName('Sacha');
		$sacha->setEnabled(true);
		$sacha->setStaff(true);

		$userManager->updateUser($sacha);

        $cristian = $userManager->createUser();
		$cristian->setUsername('cdouce');
		$cristian->setEmail('cristian.douce@gmail.com');
		$cristian->setPlainPassword('123456');
		$cristian->setName('Cristian');
		$cristian->setEnabled(true);

		$userManager->updateUser($cristian);
    }
}
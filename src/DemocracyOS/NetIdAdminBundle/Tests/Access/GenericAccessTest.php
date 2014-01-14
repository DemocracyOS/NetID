<?php

namespace DemocracyOS\NetIdAdminBundle\Tests\Access;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\BrowserKit\Cookie;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

abstract class GenericAccessTest extends WebTestCase
{
	/**
     * @var \Doctrine\ORM\EntityManager
     */
    protected $em;

    protected $session;

    /**
     * {@inheritDoc}
     */
    public function setUp()
    {
        static::$kernel = static::createKernel();
        static::$kernel->boot();
        $this->client = static::createClient();
        $this->em = static::$kernel->getContainer()
            ->get('doctrine')
            ->getManager()
        ;


        $purger = new \Doctrine\Common\DataFixtures\Purger\ORMPurger($this->em);
        $executor = new \Doctrine\Common\DataFixtures\Executor\ORMExecutor($this->em, $purger);
        $executor->purge();

        // Load fixtures
        $loader = new \Doctrine\Common\DataFixtures\Loader;
        $fixtures = array();
        $fixtures[] = new \DemocracyOS\NetIdAdminBundle\Tests\DataFixtures\ORM\Groups();
        $fixtures[] = new \DemocracyOS\NetIdAdminBundle\Tests\DataFixtures\ORM\Users();
        foreach ($fixtures as $fixture) {
            $loader->addFixture($fixture);
        }
        $executor->execute($loader->getFixtures());
    }

    protected function cantAccess($route)
    {
        $this->client->request('GET', $route);
        $this->assertTrue(403 === $this->client->getResponse()->getStatusCode());
    }

    protected function login($username, $password)
    {
    	$crawler = $this->client->request('GET', '/admin/login');

        $form = $crawler->selectButton('_submit')->form();
        $this->client->submit($form, array('_username' => $username, '_password' => $password));
    }
}

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
    private $em;

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
    }

    protected function cantAccess($route)
    {
        $this->client->request('GET', $route);
        $this->assertTrue(403 === $this->client->getResponse()->getStatusCode());
    }

    protected function login($groupname)
    {
        $group = $this->em->getRepository('ApplicationSonataUserBundle:Group')->findOneByName($groupname);

    	$session = $this->client->getContainer()->get('session');

        $firewall = 'admin';
        $token = new UsernamePasswordToken('admin', null, $firewall, $group->getRoles());
        $session->set('_security_'.$firewall, serialize($token));
        $session->save();

        $cookie = new Cookie($session->getName(), $session->getId());
        $this->client->getCookieJar()->set($cookie);
    }
}
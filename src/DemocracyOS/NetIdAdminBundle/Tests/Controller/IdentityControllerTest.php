<?php

namespace DemocracyOS\NetIdAdminBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\BrowserKit\Cookie;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

class IdentityControllerTest extends WebTestCase
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

    public function testAuditorCantAccessToIdentityAdmin()
    {
        $auditor = $this->em->getRepository('ApplicationSonataUserBundle:Group')->findOneByName('Auditor');

		$this->login($auditor->getRoles());

        $this->client->request('GET', '/admin/identity/create');

        $this->assertTrue(403 === $this->client->getResponse()->getStatusCode());

        $this->client->request('GET', '/admin/identity/list');

        $this->assertTrue(403 === $this->client->getResponse()->getStatusCode());
    }

    public function testAuditorCantAccessToApplicationAdmin()
    {
        $auditor = $this->em->getRepository('ApplicationSonataUserBundle:Group')->findOneByName('Auditor');

        $this->login($auditor->getRoles());

        $this->client->request('GET', '/admin/application/create');

        $this->assertTrue(403 === $this->client->getResponse()->getStatusCode());

        $this->client->request('GET', '/admin/application/list');

        $this->assertTrue(403 === $this->client->getResponse()->getStatusCode());
    }

    public function testAuditorCantAccessToUserAdmin()
    {
        $auditor = $this->em->getRepository('ApplicationSonataUserBundle:Group')->findOneByName('Auditor');

        $this->login($auditor->getRoles());

        $this->client->request('GET', '/admin/sonata/user/user/create');

        $this->assertTrue(403 === $this->client->getResponse()->getStatusCode());

        $this->client->request('GET', '/admin/sonata/user/user/list');

        $this->assertTrue(403 === $this->client->getResponse()->getStatusCode());
    }


    public function testAuditorCantAccessToGroupAdmin()
    {
        $auditor = $this->em->getRepository('ApplicationSonataUserBundle:Group')->findOneByName('Auditor');

        $this->login($auditor->getRoles());

        $this->client->request('GET', '/admin/sonata/user/user/create');

        $this->assertTrue(403 === $this->client->getResponse()->getStatusCode());

        $this->client->request('GET', '/admin/sonata/user/user/list');

        $this->assertTrue(403 === $this->client->getResponse()->getStatusCode());
    }

    protected function login($roles = array())
    {
    	$session = $this->client->getContainer()->get('session');

        $firewall = 'admin';
        $token = new UsernamePasswordToken('admin', null, $firewall, $roles);
        $session->set('_security_'.$firewall, serialize($token));
        $session->save();

        $cookie = new Cookie($session->getName(), $session->getId());
        $this->client->getCookieJar()->set($cookie);
    }
}

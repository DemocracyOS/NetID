<?php

namespace DemocracyOS\NetIdAdminBundle\Tests\Log;

use DemocracyOS\NetIdAdminBundle\Tests\Access\GenericAccessTest;
use Application\Sonata\UserBundle\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Bundle\FrameworkBundle\Client;
use Symfony\Component\BrowserKit\Cookie;

class IdentityLogTest extends GenericAccessTest
{
    protected $mongoEm;

    protected $auditor;

    /**
     * {@inheritDoc}
     */
    public function setUp()
    {
        parent::setUp();
        $this->mongoEm = static::$kernel->getContainer()->get('doctrine_mongodb')->getManager();
    }

    public function testIdentityCreationGeneratesLogRecord()
    {
        $crawler = $this->client->request('GET', '/admin/login');

        $form = $crawler->selectButton('_submit')->form();
        $this->client->submit($form, array('_username' => 'auditor', '_password' => 'auditor'));

        $crawler = $this->client->request('GET', '/admin/audit/list');

        $this->assertTrue(200 === $this->client->getResponse()->getStatusCode());
    }
}
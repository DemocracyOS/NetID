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
        $this->login('admin', 'admin');

        $crawler = $this->client->request('GET', '/admin/identity/create');
        $form = $crawler->selectButton('btn_create_and_edit')->form();
        var_dump($form);exit;
        $this->client->submit($form, array('_username' => $username, '_password' => $password));

        var_dump($this->client->getResponse()->getStatusCode());exit;
    }
}
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

        $logsCount = $this->getLogsCount();
        
        $this->persistTestIdentity();

        $newCount = $this->getLogsCount();
        $this->assertEquals($logsCount + 1, $newCount);
    }

    public function testIdentityUpdateGeneratesLogRecord()
    {
        $this->login('admin', 'admin');
        
        $this->persistTestIdentity();
        
        $logsCount = $this->getLogsCount();

        $this->updateTestIdentity();

        $newCount = $this->getLogsCount();
        $this->assertEquals($logsCount + 1, $newCount);
    }

    public function testIdentityDeleteGeneratesLogRecord()
    {
        $this->login('superAdmin', 'superAdmin');
        
        $this->persistTestIdentity();
        
        $logsCount = $this->getLogsCount();

        $this->deleteTestIdentity();

        $newCount = $this->getLogsCount();
        $this->assertEquals($logsCount + 1, $newCount);
    }

    protected function persistTestIdentity()
    {
        $crawler = $this->client->request('GET', '/admin/identity/create');
        $form = $crawler->selectButton('btn_create_and_edit')->form();
        $values = $form->getValues();
        foreach ($values as $value => $set) {
            if (stristr($value, 'firstname'))
            {
                $firstname = $value;
            }
            if (stristr($value, 'lastname'))
            {
                $lastname = $value;
            }
        }
        $this->client->submit($form, array($firstname => 'John', $lastname => 'Doe'));
    }

    protected function updateTestIdentity()
    {
        $identityRepository = $this->em->getRepository('DemocracyOSNetIdAdminBundle:Identity');
        $identities = $identityRepository->findAll();
        $identity = $identities[0];
        $crawler = $this->client->request('GET', sprintf('/admin/identity/%d/edit', $identity->getId()));
        $form = $crawler->selectButton('btn_update_and_edit')->form();
        $values = $form->getValues();
        foreach ($values as $value => $set) {
            if (stristr($value, 'firstname'))
            {
                $firstname = $value;
            }
        }
        $this->client->submit($form, array($firstname => 'Jane'));
    }

    protected function deleteTestIdentity()
    {
        $identityRepository = $this->em->getRepository('DemocracyOSNetIdAdminBundle:Identity');
        $identities = $identityRepository->findAll();
        $identity = $identities[0];
        $crawler = $this->client->request('POST', sprintf('/admin/identity/%d/delete', $identity->getId()));
        $form = $crawler->selectButton('delete')->form();
        $this->client->submit($form);
    }

    protected function getLogsCount()
    {
        $logRepository = $this->mongoEm->getRepository('DemocracyOSNetIdAdminBundle:LogRecord');
        $logs = $logRepository->findAll();
        $count = count($logs);
        return $count;
    }
}
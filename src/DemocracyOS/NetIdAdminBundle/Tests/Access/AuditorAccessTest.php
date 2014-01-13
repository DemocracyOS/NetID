<?php

namespace DemocracyOS\NetIdAdminBundle\Tests\Access;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\BrowserKit\Cookie;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

class AuditorAccessTest extends GenericAccessTest
{
    public function testAuditorCantAccessToIdentityAdmin()
    {
        $this->login('Auditor');
        
        $this->cantAccess('/admin/identity/create');
        $this->cantAccess('/admin/identity/list');
    }

    public function testAuditorCantAccessToApplicationAdmin()
    {
        $this->login('Auditor');
        
        $this->cantAccess('/admin/application/create');
        $this->cantAccess('/admin/application/list');
    }

    public function testAuditorCantAccessToUserAdmin()
    {
        $this->login('Auditor');

        $this->cantAccess('/admin/user/create');
        $this->cantAccess('/admin/user/list');
    }

    public function testAuditorCantAccessToGroupAdmin()
    {
        $this->login('Auditor');

        $this->cantAccess('/admin/group/list');
        $this->cantAccess('/admin/group/create');
    }
}

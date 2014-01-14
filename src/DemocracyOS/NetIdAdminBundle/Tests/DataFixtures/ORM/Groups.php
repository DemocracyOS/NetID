<?php

namespace DemocracyOS\NetIdAdminBundle\Tests\DataFixtures\ORM;

use DemocracyOS\NetIdAdminBundle\DataFixtures\ORM\Groups as BaseGroups;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;

class Groups extends BaseGroups implements OrderedFixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function getOrder()
    {
        return 1;
    }
}
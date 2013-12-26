<?php

namespace DemocracyOS\NetIdAdminBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use DemocracyOS\NetIdAdminBundle\Entity\LegalIdType;

class LegalIdTypes implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $dni = new LegalIdType();
        $dni->setName('DNI');

        $manager->persist($dni);
        $manager->flush();
    }
}
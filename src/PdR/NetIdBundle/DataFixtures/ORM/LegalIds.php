<?php

namespace PdR\NetIdBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use PdR\NetIdBundle\Entity\LegalId;

class LegalIds implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $dni = new LegalId();
        $dni->setName('DNI');

        $manager->persist($dni);
        $manager->flush();
    }
}
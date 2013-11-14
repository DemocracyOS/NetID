<?php

namespace DeR\NetIdBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use DeR\NetIdBundle\Entity\LegalId;

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
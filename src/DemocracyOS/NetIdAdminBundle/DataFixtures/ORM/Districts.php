<?php

namespace DemocracyOS\NetIdAdminBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use DemocracyOS\NetIdAdminBundle\Entity\District;

class Districts implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $buenosAiresCity = new District();
        $buenosAiresCity->setName('Ciudad Autónoma de Buenos Aires');

        $manager->persist($buenosAiresCity);
        $manager->flush();
    }
}
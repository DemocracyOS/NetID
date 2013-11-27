<?php

namespace DeR\NetIdBundle\Repository;

use Doctrine\ORM\EntityRepository;
use DeR\NetIdBundle\Entity\IdentitySearch;

class IdentityRepository extends EntityRepository
{
	public function findOneByClientTokenAndForeignId($token, $foreignId)
    {
        return $this->getEntityManager()
            ->createQuery(
                'SELECT i FROM DeRNetIdBundle:Identity i 
                JOIN i.clients ic 
                JOIN ic.client c
                JOIN c.tokens t 
                WHERE t.token = :token and ic.foreignId = :foreignId'
            )
            ->setParameter('token', $token)
            ->setParameter('foreignId', $foreignId)
            ->getSingleResult();
    }

    public function search(IdentitySearch $identitySearch)
    {
        return $this->getEntityManager()
            ->createQuery(
                'SELECT i FROM DeRNetIdBundle:Identity i 
                WHERE   (:email is null or i.email = :email)
                AND     (:legalId is null or i.legalId = :legalId)
                AND     (:name is null or i.name = :name)
                AND     (:lastname is null or i.lastname = :lastname)'
            )
            ->setParameter('email', $identitySearch->getEmail())
            ->setParameter('legalId', $identitySearch->getLegalId())
            ->setParameter('name', $identitySearch->getFirstname())
            ->setParameter('lastname', $identitySearch->getLastname())
            ->getResult();
    }
}
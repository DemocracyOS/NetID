<?php

namespace DeR\NetIdBundle\Repository;

use Doctrine\ORM\EntityRepository;

class IdentityRepository extends EntityRepository
{
	public function findOneByClientTokenAndForeignId($token, $foreignId)
    {
        return $this->getEntityManager()
            ->createQuery(
                'SELECT u FROM DeRNetIdBundle:User u 
                JOIN u.clients uc 
                JOIN uc.client c
                JOIN c.tokens t 
                WHERE t.token = :token and uc.foreignId = :foreignId'
            )
            ->setParameter('token', $token)
            ->setParameter('foreignId', $foreignId)
            ->getSingleResult();
    }
}
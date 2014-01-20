<?php

namespace DemocracyOS\NetIdAdminBundle\Repository;

use Doctrine\ORM\EntityRepository;
use DemocracyOS\NetIdAdminBundle\Entity\IdentitySearch;

class ApplicationRepository extends EntityRepository
{
    public function findOneByAccessToken($token)
    {
        try {
            return $this->getEntityManager()
                ->createQuery(
                    "SELECT at, a FROM DemocracyOSNetIdApiBundle:Application a
                    INNER JOIN a.accessTokens at
                    WHERE   (at.token = :token)"
                )
                ->setParameter('token', $token)
                ->getSingleResult();
        } catch (\Doctrine\Orm\NoResultException $e) {
            return null;
        }
    }
}
<?php

namespace DemocracyOS\NetIdAdminBundle\Repository;

use Doctrine\ORM\EntityRepository;
use DemocracyOS\NetIdAdminBundle\Entity\IdentitySearch;

class IdentityRepository extends EntityRepository
{
    public function search(IdentitySearch $identitySearch)
    {
        return $this->getEntityManager()
            ->createQuery(
                "SELECT i FROM DemocracyOSNetIdAdminBundle:Identity i 
                LEFT JOIN i.emails e
                WHERE   (:email is null or e.email = :email)
                AND     (:legalId is null or i.legalId = :legalId)
                AND     (:firstname is null or i.firstname = :firstname)
                AND     (:lastname is null or i.lastname = :lastname)"
            )
            ->setParameter('email', $identitySearch->getEmail())
            ->setParameter('legalId', $identitySearch->getLegalId())
            ->setParameter('firstname', $identitySearch->getFirstname())
            ->setParameter('lastname', $identitySearch->getLastname())
            ->getResult();
    }

    public function findOneByEmail($email)
    {
        try {
            return $this->getEntityManager()
                ->createQuery(
                    "SELECT i FROM DemocracyOSNetIdAdminBundle:Identity i 
                    LEFT JOIN i.emails e
                    WHERE   (:email is null or e.email = :email)"
                )
                ->setParameter('email', $email)
                ->getSingleResult();
        } catch (\Doctrine\Orm\NoResultException $e) {
            return null;
        }
    }
}
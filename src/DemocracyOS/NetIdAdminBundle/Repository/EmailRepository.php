<?php

namespace DemocracyOS\NetIdAdminBundle\Repository;

use Doctrine\ORM\EntityRepository;
use DemocracyOS\NetIdAdminBundle\Entity\IdentitySearch;

class EmailRepository extends EntityRepository
{
	public function findByForeignIdAndEmail($foreignId, $email)
    {
        try {
            return $this->getEntityManager()
                ->createQuery(
                    "SELECT e FROM DemocracyOSNetIdAdminBundle:Email e
                    INNER JOIN e.identity i
                    INNER JOIN i.applications a
                    WHERE a.foreignId = :foreignId
                    AND e.email = :email"
                )
                ->setParameter('foreignId', $foreignId)
                ->setParameter('email', $email)
                ->getSingleResult();
        } catch (\Doctrine\Orm\NoResultException $e) {
            return null;
        }
    }
}
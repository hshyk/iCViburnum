<?php

namespace AppBundle\Repository\iCViburnum;

/**
 * OrganismstateRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class OrganismstateRepository extends \Doctrine\ORM\EntityRepository
{
    public function findAllIDs() {
        return $this
        ->createQueryBuilder("os")
        ->select("os.id")
        ->getQuery()
        ->getScalarResult();
    }
}

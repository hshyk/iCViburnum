<?php

namespace AppBundle\Repository\iCViburnum;

/**
 * GadmRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class GadmRepository extends \Doctrine\ORM\EntityRepository
{
    public function findByParentId($parentid) {
        $query = $this
            ->createQueryBuilder("g")
            ->select('partial g.{id, country, stateProvince, districtCountyShire, adminType}');

        if ($parentid == NULL) {
            $query->where("g.parentId IS NULL");
        }
        else {
            $query->where("g.parentId = :parentid")
            ->setParameter('parentid', $parentid);
        }
        
        $query->orderBy('g.districtCountyShire, g.stateProvince, g.country');
        
        return $query
            ->getQuery()
            ->useQueryCache(true)
            ->useResultCache(true)
            ->getResult();
    }
}

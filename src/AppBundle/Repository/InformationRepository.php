<?php

namespace AppBundle\Repository;

/**
 * InformationRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class InformationRepository extends \Doctrine\ORM\EntityRepository
{
    /**
     * Liste decroissante des informations
     */
    public function findInfoDESC()
    {
        return $this->createQueryBuilder('i')
                    ->orderBy('i.id', 'DESC')
                    ->getQuery()->getResult()
        ;
    }
}
<?php

namespace AppBundle\Repository;

/**
 * SliderRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class SliderRepository extends \Doctrine\ORM\EntityRepository
{
    /**
     * Compteur de slider
     */
    public function compteur($statut = null)
    {
        if ($statut){
            return $this->list()->select('count(s.id)')->where('s.statut = 1')->getQuery()->getSingleScalarResult();
        }else{
            return $this->list()->select('count(s.id)')->getQuery()->getSingleScalarResult();
        }
    }
    /**
     * Liste decroissante des slides
     */
    public function findListDesc($statut = null, $limit = null, $offset = null)
    {
        if ($statut){
            return $this->list($limit, $offset)->where('s.statut = 1')
                                                ->andWhere(':periode BETWEEN s.datedeb AND s.datefin')
                                                ->orderBy('s.datefin', 'ASC')
                                                ->setParameter('periode', date('Y-m-d', time()))
                                                ->getQuery()->getResult()
                ;
        }else{
            return $this->list($limit, $offset)->orderBy('s.datefin', 'DESC')->getQuery()->getResult();
        }
    }

    /**
     * recherches des slides
     */
    public function list($limit = null, $offset = null)
    {
        return $this->createQueryBuilder('s')
                    ->addSelect('t')
                    ->leftJoin('s.type', 't')
                    ->orderBy('s.id', 'DESC')
                    ->setFirstResult($offset)
                    ->setMaxResults($limit)
            ;
    }
}

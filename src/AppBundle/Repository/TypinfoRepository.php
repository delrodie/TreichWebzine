<?php

namespace AppBundle\Repository;

/**
 * TypinfoRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class TypinfoRepository extends \Doctrine\ORM\EntityRepository
{
    /**
     * Liste decroissante des types infos
     */
    public function findTypinfoDESC()
    {
        return $this->createQueryBuilder('t')
                    ->where('t.statut = 1')
                    ->orderBy('t.libelle', 'ASC')
        ;
    }
}

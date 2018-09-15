<?php

namespace AppBundle\Repository;

/**
 * TypeDossierRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class TypeDossierRepository extends \Doctrine\ORM\EntityRepository
{
    /**
     * Liste decroissante des rubriques de dossiers
     */
    public function findTypeDossierASC()
    {
        return $this->createQueryBuilder('d')
                    ->orderBy('d.libelle', 'ASC')
                    ->getQuery()->getResult()
            ;
    }

    /**
     * Liste croissante des rubriques de dossiers actives
     */
    public function findTypeActifASC()
    {
        return $this->createQueryBuilder('d')
                    ->where('d.statut = 1')
                    ->orderBy('d.libelle', 'ASC')
            ;
    }
}

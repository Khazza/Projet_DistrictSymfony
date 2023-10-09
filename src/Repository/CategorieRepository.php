<?php

namespace App\Repository;

use App\Entity\Categorie;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Categorie>
 *
 * @method Categorie|null find($id, $lockMode = null, $lockVersion = null)
 * @method Categorie|null findOneBy(array $criteria, array $orderBy = null)
 * @method Categorie[]    findAll()
 * @method Categorie[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CategorieRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Categorie::class);
    }

    /**
     * @return Categorie[]
     */
    public function findPopularCategories(int $limit = 6): array
    {
        return $this->createQueryBuilder('c')
            ->select('c, SUM(d.quantite) AS HIDDEN orderSum')
            ->join('c.plats', 'p')
            ->join('p.details', 'd')
            ->join('d.commande', 'co')
            ->groupBy('c.id')
            ->orderBy('orderSum', 'DESC')
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult();
    }
}

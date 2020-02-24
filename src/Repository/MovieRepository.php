<?php

declare(strict_types=1);

namespace Movifony\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Movifony\Entity\ImdbMovie;

/**
 * Retrieve movie from DB
 *
 * @author Corentin Bouix <cbouix@clever-age.com>
 */
class MovieRepository extends ServiceEntityRepository
{
    /**
     * @param string $entityClass The class name of the entity this repository manages
     */
    public function __construct(ManagerRegistry $registry, string $entityClass = ImdbMovie::class)
    {
        parent::__construct($registry, $entityClass);
    }

    /**
     * @param int $limit
     *
     * @return array|ImdbMovie[]
     */
    public function findLatestMovies(int $limit): array
    {
        $qb = $this->createQueryBuilder('m')
            ->setMaxResults($limit)
            ->orderBy('m.id', 'DESC');

        return $qb->getQuery()->getArrayResult();
    }
}

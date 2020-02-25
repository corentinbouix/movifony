<?php

declare(strict_types=1);

namespace Movifony\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Movifony\Entity\ImdbPerson;

class PersonRepository extends ServiceEntityRepository
{
    /**
     * @param string $entityClass The class name of the entity this repository manages
     */
    public function __construct(ManagerRegistry $registry, string $entityClass = ImdbPerson::class)
    {
        parent::__construct($registry, $entityClass);
    }

    /**
     * @param string $identifier
     *
     * @return object|null
     */
    public function findByIdentifier(string $identifier): ?ImdbPerson
    {
        return $this->findOneBy(['identifier' => $identifier]);
    }
}

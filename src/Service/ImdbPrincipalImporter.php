<?php

declare(strict_types=1);

namespace Movifony\Service;

use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Persistence\ObjectManager;
use Movifony\DTO\DtoInterface;
use Movifony\DTO\PersonDto;
use Movifony\Entity\BusinessObjectInterface;
use Movifony\Entity\ImdbMovie;
use Movifony\Entity\ImdbPerson;
use Movifony\Factory\ImbdFactory;

/**
 * Class ImdbPrincipalImporter
 *
 * @author Corentin Bouix <cbouix@clever-age.com>
 */
class ImdbPrincipalImporter implements ImporterInterface
{
    protected ManagerRegistry $managerRegistry;

    /**
     * @param ManagerRegistry $managerRegistry
     */
    public function __construct(ManagerRegistry $managerRegistry)
    {
        $this->managerRegistry = $managerRegistry;
    }

    /**
     * @inheritDoc
     */
    public function read(array $data): ?PersonDto
    {
        if (!$this->isMatchingMovie($data['tconst'])) {
            return null;
        }

        return new PersonDto($data['nconst'], $data['tconst']);
    }

    /**
     * @inheritDoc
     */
    public function process(DtoInterface $data): ImdbPerson
    {
        return ImbdFactory::createPerson($data);
    }

    /**
     * @inheritDoc
     */
    public function write(BusinessObjectInterface $data): bool
    {
        $om = $this->getObjectManager();
        if ($om === null) {
            return false;
        }

        $om->persist($data);
        $om->flush();

        return true;
    }

    public function clear(): void
    {
        $this->managerRegistry->getManager()->clear();
    }

    /**
     * @return ObjectManager|null
     */
    protected function getObjectManager(): ?ObjectManager
    {
        return $this->managerRegistry->getManagerForClass(ImdbMovie::class);
    }

    /**
     * @param $movieIdentifier
     *
     * @return bool
     */
    protected function isMatchingMovie(string $movieIdentifier): bool
    {
        $repository = $this->managerRegistry->getRepository(ImdbMovie::class);
        $movie = $repository->findByIdentifier($movieIdentifier);

        return $movie !== null;
    }
}

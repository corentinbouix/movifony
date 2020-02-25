<?php

declare(strict_types=1);

namespace Movifony\Service;

use Doctrine\ORM\NonUniqueResultException;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Persistence\ObjectManager;
use Movifony\DTO\DtoInterface;
use Movifony\DTO\PersonDto;
use Movifony\Entity\BusinessObjectInterface;
use Movifony\Entity\ImdbMovie;
use Movifony\Entity\ImdbPerson;
use Movifony\Factory\ImbdFactory;
use Movifony\Repository\PersonRepository;
use RuntimeException;

/**
 * Class ImdbPrincipalImporter
 *
 * @author Corentin Bouix <cbouix@clever-age.com>
 */
class ImdbPrincipalImporter implements ImporterInterface
{
    protected ManagerRegistry $managerRegistry;

    protected PersonRepository $personRepository;

    /**
     * @param ManagerRegistry  $managerRegistry
     * @param PersonRepository $personRepository
     */
    public function __construct(ManagerRegistry $managerRegistry, PersonRepository $personRepository)
    {
        $this->managerRegistry = $managerRegistry;
        $this->personRepository = $personRepository;
    }

    /**
     * @inheritDoc
     */
    public function read(array $data): ?PersonDto
    {
        $personIdentifier = $data['nconst'];
        if (!$this->isMatchingMovie($data['tconst'])) {
            return null;
        }

        $existingPerson = $this->getExistingPerson($personIdentifier);

        return new PersonDto($data['nconst'], $data['tconst'], $existingPerson === null);
    }

    /**
     * @inheritDoc
     */
    public function process(DtoInterface $data): ?ImdbPerson
    {
        /** @var PersonDto $data */
        $movie = $this->isMatchingMovie($data->getMovieIdentifier());
        if (!$movie) {
            throw new RuntimeException("Can't find back matching movie, reader process find it but not anymore");
        }

        $existingPerson = $this->getExistingPerson($data->getIdentifier());

        if (!$existingPerson) {
            $existingPerson = ImbdFactory::createPerson($data, $movie);
        }

        $moviePersons = $movie->getPersons();
        if ($moviePersons->contains($existingPerson)) {
            return null;
        }

        return $existingPerson;
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

        /** @var ImdbPerson $data */
        if ($data->isPersistenceRequired()) {
            $om->persist($data);
        }
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
     * @param string $movieIdentifier
     *
     * @return ImdbMovie|null
     */
    protected function isMatchingMovie(string $movieIdentifier): ?ImdbMovie
    {
        $repository = $this->managerRegistry->getRepository(ImdbMovie::class);

        return $repository->findByIdentifier($movieIdentifier);
    }

    /**
     * @param string $personIdentifier
     *
     * @return ImdbPerson|null
     */
    protected function getExistingPerson(string $personIdentifier): ?ImdbPerson
    {
        return $this->personRepository->findByIdentifier($personIdentifier);
    }
}

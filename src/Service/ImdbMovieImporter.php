<?php

declare(strict_types=1);

namespace Movifony\Service;

use Doctrine\Persistence\ManagerRegistry;
use Movifony\DTO\MovieDto;
use Movifony\Entity\ImdbMovie;
use Movifony\Factory\ImbdFactory;

/**
 * Class ImdbMovieImporter
 *
 * @author Corentin Bouix <cbouix@clever-age.com>
 */
class ImdbMovieImporter implements ImporterInterface
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
    public function read(array $data): MovieDto
    {
        return new MovieDto($data['title']);
    }

    /**
     * @inheritDoc
     */
    public function process(MovieDto $movieDto): ImdbMovie
    {
        return ImbdFactory::createMovie($movieDto);
    }

    /**
     * @inheritDoc
     */
    public function import(ImdbMovie $movie): bool
    {
        $om = $this->managerRegistry->getManagerForClass(ImdbMovie::class);
        if (!$om) {
            return false;
        }

        $om->persist($movie);
        $om->flush();

        return true;
    }

    public function clear(): void
    {
        $this->managerRegistry->getManager()->clear();
    }
}

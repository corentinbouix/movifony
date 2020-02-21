<?php

declare(strict_types=1);

namespace Movifony\Service;

use Movifony\DTO\MovieDto;
use Movifony\Entity\ImdbMovie;
use Movifony\Entity\MovieInterface;
use Movifony\Factory\ImbdFactory;
use Movifony\Factory\ImbMovieFactory;

/**
 * Class ImdbMovieImporter
 *
 * @author Corentin Bouix <cbouix@clever-age.com>
 */
class ImdbMovieImporter implements ImporterInterface
{
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
    public function process(MovieDto $movieDto): MovieInterface
    {
        return ImbdFactory::createMovie($movieDto);
    }

    /**
     * @inheritDoc
     */
    public function import(ImdbMovie $movie): bool
    {
        // TODO: Implement import() method.
    }
}

<?php

declare(strict_types=1);

namespace Movifony\Service;

use Movifony\DTO\MovieDto;
use Movifony\Entity\Movie;

/**
 * Class ImdbMovieImporter
 *
 * @author Corentin Bouix <cbouix@clever-age.com>
 */
class ImdbMovieImporter implements ImporterInterface
{

    public function import(Movie $movie): bool
    {

    }

    public function process(MovieDto $movieDto) {
        // appeler la Movie factory
        // récuperer un Movie créé depuis le MovieDTO donné par factory
    }

    public function read(array $movie) {

    }
}

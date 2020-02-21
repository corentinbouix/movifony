<?php

declare(strict_types=1);

namespace Movifony\Service;

use Movifony\Entity\Movie;

/**
 * Define import available logic for movie import
 */
interface ImporterInterface
{
    public function import(Movie $movie): bool;


}

<?php

declare(strict_types=1);

namespace Movifony\Service;

use Movifony\DTO\MovieDto;
use Movifony\Entity\ImdbMovie;
use Movifony\Entity\MovieInterface;

/**
 * Define import available logic for movie import
 */
interface ImporterInterface
{
    /**
     * Transfer array data to a DTO
     *
     * @param array $data
     *
     * @return MovieDto
     */
    public function read(array $data): MovieDto;

    /**
     * Transform DTO to a Movie
     *
     * @param MovieDto $movieDto
     *
     * @return MovieInterface
     */
    public function process(MovieDto $movieDto): MovieInterface;

    /**
     * Import Movie object to database
     *
     * @param ImdbMovie $movie
     *
     * @return bool
     */
    public function import(ImdbMovie $movie): bool;
}

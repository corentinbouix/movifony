<?php

declare(strict_types=1);

namespace Movifony\Factory;

use Movifony\DTO\MovieDto;
use Movifony\DTO\PersonDto;
use Movifony\Entity\ImdbMovie;
use Movifony\Entity\ImdbPerson;

/**
 * Class ImbdMovieFactory
 *
 * @author Corentin Bouix <cbouix@clever-age.com>
 */
class ImbdFactory
{
    /**
     * @param MovieDto $movieDto
     *
     * @return ImdbMovie
     */
    public static function createMovie(MovieDto $movieDto): ImdbMovie
    {
        $movie = new ImdbMovie();
        $movie->setTitle($movieDto->getTitle());
        $movie->setIdentifier($movieDto->getIdentifier());

        return $movie;
    }

    /**
     * @param PersonDto $personDto
     * @param ImdbMovie $movie
     *
     * @return ImdbPerson
     */
    public static function createPerson(PersonDto $personDto, ImdbMovie $movie): ImdbPerson
    {
        $person = new ImdbPerson();
        $person->setIdentifier($personDto->getIdentifier());
        $person->addMovie($movie);
        $person->setCategory($personDto->getCategory());
        $person->needToBePersisted();

        return $person;
    }
}

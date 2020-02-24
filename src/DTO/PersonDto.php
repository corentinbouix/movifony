<?php

declare(strict_types=1);

namespace Movifony\DTO;

/**
 * Represent a person that coming from IMDB data
 *
 * @author Corentin Bouix <cbouix@clever-age.com>
 */
class PersonDto implements DtoInterface
{
    protected string $identifier;

    protected string $movieIdentifier;

    /**
     * @param string $identifier
     * @param string $movieIdentifier
     */
    public function __construct(string $identifier, string $movieIdentifier)
    {
        $this->identifier = $identifier;
        $this->movieIdentifier = $movieIdentifier;
    }

    /**
     * @return string
     */
    public function getIdentifier(): string
    {
        return $this->identifier;
    }

    /**
     * @return string
     */
    public function getMovieIdentifier(): string
    {
        return $this->movieIdentifier;
    }
}

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

    protected bool $needPersist;

    /**
     * @param string $identifier
     * @param string $movieIdentifier
     * @param bool   $needPersist
     */
    public function __construct(string $identifier, string $movieIdentifier, bool $needPersist)
    {
        $this->identifier = $identifier;
        $this->movieIdentifier = $movieIdentifier;
        $this->needPersist = $needPersist;
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

    /**
     * Tell us whether it's already existing or not into DB
     *
     * @return bool
     */
    public function needPersist(): bool
    {
        return $this->needPersist;
    }
}

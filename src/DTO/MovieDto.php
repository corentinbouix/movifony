<?php

declare(strict_types=1);

namespace Movifony\DTO;

/**
 * Handle raw data from IMDB import file
 *
 * @author Corentin Bouix <cbouix@clever-age.com>
 */
class MovieDto implements DtoInterface
{
    private string $identifier;
    private string $title;

    /**
     * @param string $identifier
     * @param string $title
     */
    public function __construct(string $identifier, string $title)
    {
        $this->identifier = $identifier;
        $this->title = $title;
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
    public function getTitle(): string
    {
        return $this->title;
    }
}

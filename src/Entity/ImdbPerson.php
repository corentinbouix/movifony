<?php

declare(strict_types=1);

namespace Movifony\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 * @ORM\Table(name="mf_person")
 *
 * @author Corentin Bouix <cbouix@clever-age.com>
 */
class ImdbPerson implements BusinessObjectInterface
{
    /**
     * @var int
     *
     * @ORM\Id
     * @ORM\Column(name="id", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected int $id;

    /**
     * @var string
     *
     * @ORM\Column(name="identifier", type="string")
     */
    protected string $identifier;

    /**
     * @var string
     *
     * @ORM\Column(name="movie", type="string")
     */
    protected string $movie;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getIdentifier(): string
    {
        return $this->identifier;
    }

    /**
     * @param string $identifier
     */
    public function setIdentifier(string $identifier): void
    {
        $this->identifier = $identifier;
    }

    /**
     * @return string
     */
    public function getMovie(): string
    {
        return $this->movie;
    }

    /**
     * @param string $movie
     */
    public function setMovie(string $movie): void
    {
        $this->movie = $movie;
    }
}

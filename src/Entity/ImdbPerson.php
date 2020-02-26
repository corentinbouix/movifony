<?php

declare(strict_types=1);

namespace Movifony\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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
     * @ORM\Column(name="category", type="string")
     */
    protected string $category;

    /**
     * @var Collection|ArrayCollection|ImdbMovie[]
     *
     * @ORM\ManyToMany(targetEntity="Movifony\Entity\ImdbMovie", inversedBy="persons")
     */
    protected Collection $movies;

    /** @var bool */
    protected bool $needPersist = false;

    public function __construct()
    {
        $this->movies = new ArrayCollection();
    }

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
    public function getCategory(): string
    {
        return $this->category;
    }

    /**
     * @param string $category
     */
    public function setCategory(string $category): void
    {
        $this->category = $category;
    }

    /**
     * @return ArrayCollection|ImdbMovie[]
     */
    public function getMovies(): Collection
    {
        return $this->movies;
    }

    /**
     * @param array|ArrayCollection|ImdbMovie[] $movies
     */
    public function setMovies(array $movies): void
    {
        $this->movies = $movies;
    }

    /**
     * @param ImdbMovie $movie
     */
    public function addMovie(ImdbMovie $movie): void
    {
        $this->movies->add($movie);
    }

    /**
     * @param ImdbMovie $movie
     *
     */
    public function removeMovie(ImdbMovie $movie): void
    {
        $this->movies->removeElement($movie);
    }

    public function needToBePersisted(): void
    {
        $this->needPersist = true;
    }

    /**
     * @return bool
     */
    public function isPersistenceRequired(): bool
    {
        return $this->needPersist;
    }
}

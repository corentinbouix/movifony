<?php

declare(strict_types=1);

namespace Movifony\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Movie
 *
 * @ORM\Entity(repositoryClass="Movifony\Repository\MovieRepository")
 * @ORM\Table(name="mf_movie")
 *
 * @author Corentin Bouix <cbouix@clever-age.com>
 */
class ImdbMovie implements MovieInterface
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
     * @ORM\Column(name="title", type="string")
     */
    protected string $title;

    /**
     * @var string|null
     *
     * @ORM\Column(name="poster_url", type="string", nullable=true)
     */
    protected ?string $posterUrl;

    /**
     * @var Collection|ArrayCollection|ImdbPerson[]
     *
     * @ORM\ManyToMany(targetEntity="Movifony\Entity\ImdbPerson", mappedBy="movies")
     * @ORM\JoinTable(name="mf_movie_person")
     */
    protected Collection $persons;

    public function __construct()
    {
        $this->persons = new ArrayCollection();
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
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    /**
     * @return string
     */
    public function getPosterUrl(): string
    {
        return $this->posterUrl;
    }

    /**
     * @param string|null $posterUrl
     */
    public function setPosterUrl(?string $posterUrl): void
    {
        $this->posterUrl = $posterUrl;
    }

    /**
     * @return ArrayCollection|ImdbPerson[]
     */
    public function getPersons(): Collection
    {
        return $this->persons;
    }

    /**
     * @param array|ArrayCollection|ImdbPerson[] $persons
     */
    public function setPersons(array $persons): void
    {
        $this->persons = $persons;
    }

    /**
     * @param ImdbPerson $person
     */
    public function addPerson(ImdbPerson $person): void
    {
        $this->persons->add($person);
    }

    /**
     * @param ImdbPerson $person
     */
    public function removePerson(ImdbPerson $person): void
    {
        $this->persons->removeElement($person);
    }
}

<?php

declare(strict_types=1);

namespace Movifony\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Movie
 *
 * @ORM\Entity()
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
     * @var string
     *
     * @ORM\Column(name="poster_url", type="string")
     */
    protected string $posterUrl;

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
     * @param string $posterUrl
     */
    public function setPosterUrl(string $posterUrl): void
    {
        $this->posterUrl = $posterUrl;
    }
}

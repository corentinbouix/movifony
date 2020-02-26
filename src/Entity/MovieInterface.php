<?php

declare(strict_types=1);

namespace Movifony\Entity;

/**
 * Interface MovieInterface
 */
interface MovieInterface extends BusinessObjectInterface
{
    /**
     * @return string
     */
    public function getTitle(): ?string;

    /**
     * @param string $title
     */
    public function setTitle(string $title): void;
}

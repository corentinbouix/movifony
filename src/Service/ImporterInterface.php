<?php

declare(strict_types=1);

namespace Movifony\Service;

use Movifony\DTO\DtoInterface;
use Movifony\Entity\BusinessObjectInterface;

/**
 * Base interface for importer
 */
interface ImporterInterface
{
    /**
     * @param $data
     *
     * @return DtoInterface|null
     */
    public function read(array $data): ?DtoInterface;

    /**
     * @param $data
     *
     * @return BusinessObjectInterface|null
     */
    public function process(DtoInterface $data): ?BusinessObjectInterface;

    /**
     * @param $data
     *
     * @return bool
     */
    public function write(BusinessObjectInterface $data): bool;
}

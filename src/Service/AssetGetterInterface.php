<?php

declare(strict_types=1);

namespace Movifony\Service;

/**
 * Return an asset for a given movie identifier
 *
 * @author Corentin Bouix <cbouix@clever-age.com>
 */
interface AssetGetterInterface
{
    /**
     * Return the URL string of the asset
     *
     * @param string $identifier
     *
     * @return string
     */
    public function getPoster(string $identifier): string;
}

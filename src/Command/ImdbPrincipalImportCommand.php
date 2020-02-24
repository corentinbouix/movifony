<?php

declare(strict_types=1);

namespace Movifony\Command;

use Movifony\Service\ImdbPrincipalImporter;
use Psr\Log\LoggerInterface;

/**
 * Import principals from IMDB
 *
 * @author Corentin Bouix <cbouix@clever-age.com>
 */
class ImdbPrincipalImportCommand extends AbstractTsvImportCommand
{
    protected static $defaultName = 'movifony:import:principal:imdb';

    /**
     * @param string          $projectDir
     * @param                 $importer
     * @param LoggerInterface $logger
     */
    public function __construct(string $projectDir, ImdbPrincipalImporter $importer, LoggerInterface $logger)
    {
        parent::__construct(static::$defaultName, $projectDir, $importer, $logger);

        $this->filename = 'title.principals.tsv';
    }
}

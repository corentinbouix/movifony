<?php

declare(strict_types=1);

namespace Movifony\Command;

use Movifony\Service\ImdbMovieMovieImporter;
use Psr\Log\LoggerInterface;

/**
 * Command that will import IMDB movies data from TSV file
 *
 * @link   https://www.imdb.com/interfaces/
 *
 * @author Corentin Bouix <cbouix@clever-age.com>
 */
class ImdbMovieImportCommand extends AbstractTsvImportCommand
{
    protected static $defaultName = 'movifony:import:movies:imdb';

    /**
     * @param string                 $projectDir
     * @param ImdbMovieMovieImporter $importer
     * @param LoggerInterface        $logger
     */
    public function __construct(
        string $projectDir,
        ImdbMovieMovieImporter $importer,
        LoggerInterface $logger
    ) {
        parent::__construct(static::$defaultName, $projectDir, $importer, $logger);
        $this->filename = 'title.akas.tsv';
    }
}

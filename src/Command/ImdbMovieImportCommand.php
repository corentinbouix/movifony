<?php

declare(strict_types=1);

namespace Movifony\Command;

use League\Csv\Reader;
use League\Csv\Exception;
use Movifony\Service\ImdbMovieImporter;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Command that will import IMDB movies data from TSV file
 *
 * @link   https://www.imdb.com/interfaces/
 *
 * @author Corentin Bouix <cbouix@clever-age.com>
 */
class ImdbMovieImportCommand extends Command
{
    protected const MOVIE_FILENAME = 'title.akas.tsv';

    protected static $defaultName = 'movifony:import:movies:imdb';

    protected string $projectDir;

    protected ImdbMovieImporter $imdbImporter;

    protected LoggerInterface $logger;

    public function __construct(
        string $name = null,
        string $projectDir,
        ImdbMovieImporter $imdbMovieImporter,
        LoggerInterface $logger
    ) {
        parent::__construct($name);
        $this->projectDir = $projectDir;
        $this->imdbImporter = $imdbMovieImporter;
        $this->logger = $logger;
    }

    /**
     * @param InputInterface  $input
     * @param OutputInterface $output
     *
     * @throws Exception
     */
    protected function execute(InputInterface $input, OutputInterface $output): void
    {
        // load the CSV document from a file path
        $csv = Reader::createFromPath($this->getImportFilePath(), 'r');
        $csv->setHeaderOffset(0);
        $csv->setDelimiter("\t");

        $records = $csv->getRecords();

        foreach ($records as $record) {
            $movieDto = $this->imdbImporter->read($record);
            $movie = $this->imdbImporter->process($movieDto);
            $state = $this->imdbImporter->import($movie);

            if (!$state) {
                $this->logger->warning("Can't import movie with title: {$movie->getTitle()}");
            }
        }
    }

    /**
     * Get file path name
     *
     * @return string
     */
    protected function getImportFilePath(): string
    {
        return implode(
            DIRECTORY_SEPARATOR,
            [
                $this->projectDir,
                'data',
                self::MOVIE_FILENAME,
            ]
        );
    }
}

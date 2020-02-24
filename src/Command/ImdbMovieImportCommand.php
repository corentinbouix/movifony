<?php

declare(strict_types=1);

namespace Movifony\Command;

use League\Csv\MapIterator;
use League\Csv\Reader;
use League\Csv\Exception;
use Movifony\Service\ImdbMovieMovieImporter;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\ProgressBar;
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
    protected const BATCH_SIZE = 1000;

    protected static $defaultName = 'movifony:import:movies:imdb';

    protected string $projectDir;

    protected ImdbMovieMovieImporter $imdbImporter;

    protected LoggerInterface $logger;

    public function __construct(
        string $name = null,
        string $projectDir,
        ImdbMovieMovieImporter $imdbMovieImporter,
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

        /** @var MapIterator $records */
        $records = $csv->getRecords();

        $progressBar = new ProgressBar($output, 20000000);

        $records->rewind();

        while ($records->valid()) {

            for ($i = 0; $i < self::BATCH_SIZE; $i++) {
                $this->importMovie($records->current());

                $records->next();
                $progressBar->advance();
            }
            $this->imdbImporter->clear();
        }

        $progressBar->finish();
    }

    /**
     * @param array $movieData
     */
    protected function importMovie(array $movieData): void
    {
        $movieDto = $this->imdbImporter->read($movieData);
        if ($movieDto !== null) {
            $movie = $this->imdbImporter->process($movieDto);
            $skipped = !$this->imdbImporter->import($movie);
        } else {
            $skipped = true;
        }

        if ($skipped) {
            $this->logger->info("Can't import movie with data:".json_encode($movieData, JSON_THROW_ON_ERROR, 512));
        } else {
            $this->logger->info("Successfully add movie with title: {$movie->getTitle()}");
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

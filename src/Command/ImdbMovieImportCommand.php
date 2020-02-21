<?php

declare(strict_types=1);

namespace Movifony\Command;

use League\Csv\Exception;
use League\Csv\Reader;
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
    /** @var string */
    protected static $defaultName = 'movifony:import:movies:imdb';

    /** @var string */
    protected $projectDir;

    protected const MOVIE_FILENAME = 'title.akas.tsv';

    public function __construct(string $name = null, string $projectDir)
    {
        parent::__construct($name);
        $this->projectDir = $projectDir;
    }

    /**
     * @param InputInterface  $input
     * @param OutputInterface $output
     *
     * @throws Exception
     */
    protected function execute(InputInterface $input, OutputInterface $output): void
    {
        //load the CSV document from a file path
        $csv = Reader::createFromPath($this->getImportFilePath(), 'r');
        $csv->setHeaderOffset(0);
        $csv->setDelimiter("\t");

//        $header = $csv->getHeader(); //returns the CSV header record
        $records = $csv->getRecords();

        foreach ($records as $record) {

            // injecter l'importer IMDB via l'injection de dépendances
            // importer un record

            // read  (array) array => DTO
             // process () DTO => Movie
            // Import () => Doctrine ORM

            $output->writeln("Processing movie with title: {$record['title']}");
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

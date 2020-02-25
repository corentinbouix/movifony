<?php

declare(strict_types=1);

namespace Movifony\Command;

use League\Csv\Exception;
use League\Csv\MapIterator;
use League\Csv\Reader;
use Movifony\Service\ImporterInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Abstract command that allow to iterate and process a larger TSV file
 *
 * @author Corentin Bouix <cbouix@clever-age.com>
 */
abstract class AbstractTsvImportCommand extends Command
{
    protected string $projectDir;
    protected string $folderPath;
    protected string $filename;

    protected int $batchSize = 1000;

    protected static $defaultName;

    protected ImporterInterface $importer;

    protected LoggerInterface $logger;

    /**
     * @param string|null     $name The name of the command; passing null means it must be set in configure()
     *
     * @param string          $projectDir
     * @param                 $importer
     * @param LoggerInterface $logger
     */
    public function __construct(
        string $name = null,
        string $projectDir,
        $importer,
        LoggerInterface $logger
    ) {
        parent::__construct($name);
        $this->projectDir = $projectDir;
        $this->importer = $importer;
        $this->logger = $logger;
        $this->folderPath = 'data';
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

            for ($i = 0; $i < $this->batchSize; $i++) {
                $this->import($records->current());

                $records->next();
                $progressBar->advance();
            }
            $this->importer->clear();
        }

        $progressBar->finish();
    }

    /**
     * @param array $data
     */
    protected function import(array $data): void
    {
        $dtoData = $this->importer->read($data);
        if ($dtoData !== null) {
            $objectData = $this->importer->process($dtoData);
            if ($objectData === null ) {
                $skipped = true;
            } else {
                $skipped = !$this->importer->write($objectData);
            }
        } else {
            $skipped = true;
        }

        if ($skipped) {
            $this->logger->info(
                "[FAIL] Can't import business object with data: ".json_encode($data, JSON_THROW_ON_ERROR, 512)
            );
        } else {
            $this->logger->info('[SUCCESS] Successfully add business object with data:'.implode(', ', $data).')');
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
                $this->folderPath,
                $this->filename,
            ]
        );
    }
}

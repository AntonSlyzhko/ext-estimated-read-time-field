<?php

namespace Espo\Modules\EstimatedReadTimeField\Classes\ConsoleCommands;

use Espo\Core\Console\Command;
use Espo\Core\Console\Command\Params;
use Espo\Core\Console\IO;
use Espo\Core\ORM\Repository\Option\SaveOption;
use Espo\Modules\EstimatedReadTimeField\Tools\EstimatedReadTime\MetadataProvider;
use Espo\ORM\EntityManager;
use Throwable;

/**
 * @noinspection PhpUnused
 */
class PopulateEstimatedReadTimeFields implements Command
{
    public function __construct(
        private EntityManager $entityManager,
        private MetadataProvider $metadataProvider
    ) {}

    public function run(Params $params, IO $io): void
    {
        $entityType = $params->getArgument(0);

        if (!$entityType) {
            $io->writeLine("Entity type must be specified as the first argument.");
            $io->setExitStatus(1);
            return;
        }

        if (!$this->entityManager->hasRepository($entityType)) {
            $io->writeLine("Entity type '$entityType' does not exist.");
            $io->setExitStatus(1);
            return;
        }

        if (count($this->metadataProvider->getEstimatedReadTimeFields($entityType)) === 0) {
            $io->writeLine("Entity type '$entityType' does not have estimatedReadTime fields.");
            $io->setExitStatus(1);
            return;
        }

        try {
            $entities = $this->entityManager
                ->getRDBRepository($entityType)
                ->sth()
                ->find();

            foreach ($entities as $entity) {
                $this->entityManager->saveEntity($entity, [
                    'populateEstimatedReadTime' => true,
                    SaveOption::SKIP_MODIFIED_BY => true,
                    SaveOption::SILENT => true
                ]);
            }
        } catch (Throwable $e) {
            $io->writeLine($e->getMessage());
            $io->setExitStatus(1);
            return;
        }

        $io->writeLine("Done");
        $io->setExitStatus(0);
    }
}

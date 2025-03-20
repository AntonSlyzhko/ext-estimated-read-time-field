<?php

namespace Espo\Modules\EstimatedReadTimeField\Hooks\Common;

use Espo\Core\Hook\Hook\BeforeSave;
use Espo\Core\ORM\Entity as CoreEntity;
use Espo\Modules\EstimatedReadTimeField\Tools\EstimatedReadTime\Helper;
use Espo\Modules\EstimatedReadTimeField\Tools\EstimatedReadTime\MetadataProvider;
use Espo\ORM\Entity;
use Espo\ORM\Repository\Option\SaveOptions;

/**
 * @implements BeforeSave<Entity>
 * @noinspection PhpUnused
 */
class EstimatedReadTime implements BeforeSave
{
    public function __construct(
        private MetadataProvider $metadataProvider,
        private Helper $helper
    ) {}

    /**
     * @inheritDoc
     */
    public function beforeSave(Entity $entity, SaveOptions $options): void
    {
        if (!$entity instanceof CoreEntity) {
            return;
        }

        foreach ($this->metadataProvider->getEstimatedReadTimeFields($entity->getEntityType()) as $name) {
            $this->processItem($entity, $options, $name);
        }
    }

    private function processItem(Entity $entity, SaveOptions $options, string $name): void
    {
        $textField = $this->metadataProvider->getTextFieldParam($entity->getEntityType(), $name);
        if (!$textField) {
            return;
        }

        if (!$entity->isAttributeChanged($textField) && !$options->get('populateEstimatedReadTime')) {
            return;
        }

        $entity->set($name, $this->helper->countSecondsToRead($entity->get($textField)));
    }
}

<?php

namespace Espo\Modules\EstimatedReadTimeField\Tools\EstimatedReadTime;

use Espo\Core\Utils\FieldUtil;

class MetadataProvider
{
    public function __construct(
        private FieldUtil $fieldUtil
    ) {}

    /**
     * @param string $entityType
     * @return string[]
     */
    public function getEstimatedReadTimeFields(string $entityType): array
    {
        return $this->fieldUtil->getFieldByTypeList($entityType, 'estimatedReadTime');
    }

    public function getTextFieldParam(string $entityType, string $field): ?string
    {
        return $this->fieldUtil->getEntityTypeFieldParam($entityType, $field, 'textField');
    }
}

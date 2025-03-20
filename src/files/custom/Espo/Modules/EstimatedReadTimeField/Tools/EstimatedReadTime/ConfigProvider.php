<?php

namespace Espo\Modules\EstimatedReadTimeField\Tools\EstimatedReadTime;

use Espo\Core\Utils\Config;

class ConfigProvider
{
    public function __construct(
        private Config $config
    ) {}

    public function getWordsPerMinute(): int
    {
        return $this->config->get('ertWordsPerMinute', 200);
    }
}

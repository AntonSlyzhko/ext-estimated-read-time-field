<?php

namespace Espo\Modules\EstimatedReadTimeField\Tools\EstimatedReadTime;

class Helper
{
    private $wps;

    public function __construct(
        ConfigProvider $configProvider
    ) {
        $this->wps = $configProvider->getWordsPerMinute();
    }

    public function countSecondsToRead(?string $text): ?int
    {
        if (empty($text)) {
            return null;
        }

        preg_match_all('/[\p{L}\p{N}]+(?:[\'\-][\p{L}\p{N}]+)*/u', $text, $matches);
        $wordCount = count($matches[0]);
        $readMinutes = $wordCount / ((double) $this->wps);
        return (int) ($readMinutes * 60);
    }
}

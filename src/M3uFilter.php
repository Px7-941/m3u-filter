<?php

namespace M3uFilter;

use M3uParser\M3uData;
use M3uParser\M3uParser;
use M3uParser\Tag\ExtInf;
use M3uParser\Tag\ExtTagInterface;

class M3uFilter
{
    /**
     * Parse m3u file.
     */
    public function parseFile(string $file): M3uData
    {
        $m3uParser = new M3uParser();
        $m3uParser->addDefaultTags();

        return $m3uParser->parseFile($file);
    }

    /**
     * Parse m3u string.
     */
    public function parse(string $str): M3uData
    {
        $m3uParser = new M3uParser();
        $m3uParser->addDefaultTags();

        return $m3uParser->parse($str);
    }

    /**
     * Parse m3u string.
     */
    public function filterByExtInfTags(M3uData $data, array $filter_array): M3uData
    {
        $output = new M3uData();
        foreach ($data as $entry) {
            $extInfTags = \array_filter($entry->getExtTags(), function (ExtTagInterface $extTag) {
                return $extTag instanceof ExtInf;
            });
            if (\count($extInfTags) > 0 && $extInfTags[0] instanceof ExtInf) {
                if ($this->filterExtInfTags($extInfTags[0], $filter_array)) {
                    $output->append($entry);
                }
            }
        }

        return $output;
    }

    /**
     * Parse m3u string.
     */
    protected function filterExtInfTags(ExtInf $extInfTag, array $filter_array): bool
    {
        foreach ($filter_array as $key => $values) {
            if ($extInfTag->hasAttribute($key) && \in_array($extInfTag->getAttribute($key), $values)) {
                return true;
            }
        }

        return false;
    }
}

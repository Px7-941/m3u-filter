<?php

namespace M3uFilter\Tests;

use M3uFilter\M3uFilter;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 * @coversNothing
 */
class M3uFilterTest extends TestCase
{
    public function testFilterM3uByGroup(): void
    {
        $filter = ['group-title' => ['UnitTest-Group', 'NotFound']];

        $M3uFilter = new M3uFilter();
        $data = $M3uFilter->parseFile(__DIR__.'/fixtures/simple.m3u');
        $data = $M3uFilter->filterByExtInfTags($data, $filter);
        self::assertEquals('UnitTest-Group', $data[0]->getExtTags()[0]->getAttribute('group-title'));
        self::assertEquals(1, \count($data));
    }
}

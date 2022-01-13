<?php

declare(strict_types=1);

/****************************************************************
 *  Copyright notice
 *
 *  (C) Mittwald CM Service GmbH & Co. KG <opensource@mittwald.de>
 *
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 2 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

namespace Mittwald\CacheStatsWidget\Widgets;

use TYPO3\CMS\Core\Localization\LanguageService;

abstract class AbstractCacheWidget implements CacheChartInterface
{
    private const LLL = 'LLL:EXT:mw_cache_widget/Resources/Private/Language/locallang.xlf:';

    protected float $usedMemory = 0.0;
    protected float $freeMemory = 0.0;
    protected float $sumMemory = 0.0;
    protected bool $widgetEnabled = false;

    public function __construct()
    {
        $this->loadData();
    }

    public function getChartData(): array
    {
        return [
            'labels' => [
                $this->getLanguageService()->sL(self::LLL . 'label.memoryUsed'),
                $this->getLanguageService()->sL(self::LLL . 'label.memoryFree'),
            ],
            'datasets' => [
                [
                    'backgroundColor' => ['#FF8700', '#93C481'],
                    'data' => [
                        $this->usedMemory,
                        $this->freeMemory
                    ]
                ]
            ],
        ];
    }

    public function getFreeMemory(): float
    {
        return $this->freeMemory;
    }

    public function getSumMemory(): float
    {
        return $this->sumMemory;
    }

    public function getWidgetEnabled(): bool
    {
        return $this->widgetEnabled;
    }

    protected function loadData(): void
    {
    }

    protected function getLanguageService(): LanguageService
    {
        return $GLOBALS['LANG'];
    }
}

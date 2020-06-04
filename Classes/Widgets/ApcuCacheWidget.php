<?php
declare(strict_types=1);
namespace Mittwald\CacheStatsWidget\Widgets;

/* * *************************************************************
 *  Copyright notice
 *
 *  (C) 2020 Mittwald CM Service GmbH & Co. KG <opensource@mittwald.de>
 *
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either any later version.
 *
 *  The GNU General Public License can be found at
 *  https://www.gnu.org/licenses/old-licenses/gpl-2.0.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 * ************************************************************* */

/**
 * The ApcuCacheWidget reads and displays the storage usage
 * of PHP APCu module
 */
class ApcuCacheWidget implements CacheChartInterface
{
    private const decimals = 2; // decimals of graph values


    /**
     * Load data from apcu extension
     */
    protected function loadData(): void
    {
        if(extension_loaded('apcu') && ini_get('apc.enabled'))
        {
            $apcuData = apcu_sma_info();
            $this->widgetEnabled = True;
            $this->usedMemory = floatval(number_format(($apcuData["seg_size"] - $apcuData["avail_mem"])/1024/1024, self::decimals));
            $this->freeMemory = floatval(number_format($apcuData["avail_mem"]/1024/1024, self::decimals));
            $this->sumMemory = floatval(number_format($apcuData["seg_size"]/1024/1024, self::decimals));
        }
    }

    public function getFreeMemory(): float
    {
        $this->loadData();
        return $this->freeMemory;
    }

    public function getSumMemory(): float
    {
        $this->loadData();
        return $this->sumMemory;
    }

    /*
    * returns the chart data
    */
    public function getChartData(): array
    {
        $this->loadData();
        return [
            'labels' => [
                "Belegter Speicher",
                "Freier Speicher"
            ],
            'datasets' => [
                [
                    'backgroundColor' => ["#1A568F", "#93C481"],
                    'data' => [$this->usedMemory, $this->freeMemory]
                ]
            ],
        ];
    }

}

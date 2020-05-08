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
 * ************************************************************* */

/**
 * The OpCacheWidget reads and displays the storage usage
 * of PHP OpCache module
 */
class OpCacheWidget implements CacheChartInterface
{
    private const decimals = 2;


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
                    'backgroundColor' => ["#FF8700", "#93C481"],
                    'data' => [$this->usedMemory, $this->freeMemory]
                ]
            ],
        ];
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

    /**
     * Load data from opcache module
     */
    protected function loadData(): void
    {
        if(extension_loaded('Zend OPcache') && ini_get('opcache.enable'))
        {
            $opcacheData = opcache_get_status()["memory_usage"];
            $this->widgetEnabled = True;
            $this->usedMemory = floatval(number_format($opcacheData["used_memory"]/1024/1024,self::decimals));
            $this->freeMemory = floatval(number_format($opcacheData["free_memory"]/1024/1024,self::decimals));
            $this->sumMemory = floatval(number_format(($opcacheData["used_memory"]+$opcacheData["free_memory"])/1024/1024,self::decimals));
        }
    }
}

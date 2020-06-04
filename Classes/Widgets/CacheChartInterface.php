<?php
declare(strict_types=1);
namespace Mittwald\CacheStatsWidget\Widgets;
use TYPO3\CMS\Dashboard\Widgets\ChartDataProviderInterface;

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

interface CacheChartInterface extends ChartDataProviderInterface{
    public function getFreeMemory(): float;
    public function getSumMemory(): float;
}
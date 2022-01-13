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

class ApcuCacheWidget extends AbstractCacheWidget
{
    /**
     * Load data from apcu extension
     */
    protected function loadData(): void
    {
        if (extension_loaded('apcu') && ini_get('apc.enabled')) {
            $apcuData = apcu_sma_info();
            $this->widgetEnabled = true;
            $this->usedMemory = (float)(
                number_format(($apcuData['seg_size'] - $apcuData['avail_mem']) / 1024 / 1024, 2)
            );
            $this->freeMemory = (float)(number_format($apcuData['avail_mem'] / 1024 / 1024, 2));
            $this->sumMemory = (float)(number_format($apcuData['seg_size'] / 1024 / 1024, 2));
        }
    }
}

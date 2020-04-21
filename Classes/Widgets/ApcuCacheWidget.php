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

use TYPO3\CMS\Core\Utility\GeneralUtility;
use Mittwald\CacheStatsWidget\Widgets\AbstractExtensionsWidget;

/**
 * The ApcuCacheWidget reads and displays the storage usage
 * of PHP APCu module
 */
class ApcuCacheWidget extends AbstractExtensionsWidget
{
    protected $title = AbstractExtensionsWidget::LANG_FILE . ':apcuCacheWidget.title';
    protected $description = AbstractExtensionsWidget::LANG_FILE . ':apcuCacheWidget.description';
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
            $this->usedMemory = number_format(($apcuData["seg_size"] - $apcuData["avail_mem"])/1024/1024, self::decimals);
            $this->freeMemory = number_format($apcuData["avail_mem"]/1024/1024, self::decimals);
            $this->sumMemory = number_format($apcuData["seg_size"]/1024/1024, self::decimals);
        }
    }

    /**
     * Renders the widget content
     * @return string
     */
    public function renderWidgetContent(): string
    {
        $this->loadData();
        return AbstractExtensionsWidget::renderWidgetContent();
    }
}
